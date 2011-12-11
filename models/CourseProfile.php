<?php

/**
 *	Course Profile Model class
 *
 *	@since 1.1
 *
 *	@Changes:
 *
 *	1. Updated the model to suite the new class model
 **/
class CourseProfile {

	public $idcourse_profile;
	public $name;
	public $course_id;
	public $staff_id;
	public $syllabus;

	/**
	 *	Save the current instance of the object to the datastore
	 *
	 *	@param	$db	PDOObject
	 *	
	 *	@return	1 if successful, else FALSE on error
	 **/
	public function save($db) {
		$r = $db->insert("course_profile", array(
				"name" => $this->name,
				"course_id" => $this->course_id,
				"syllabus" => $this->syllabus,
				"staff_id" => $this->staff_id
			));

		if(is_object($r) && get_class($r) == "PDOException") return FALSE;

		$this->idcourse_profile = $db->lastInsertId();
		$r1 = LockUnLock::addCourseProfile($this->idcourse_profile, $db);

		if(is_object($r1) && get_class($r1) == "PDOException") return $r1;

		return $r;
	}

	/**
	 *	Updates the current instance of the object in the datastore
	 *
	 *	@param	$db	PDOObject
	 *
	 *	@return	1	if successful, else PDOException
	 **/
	public function update($db) {
		return $db->update("course_profile", array(
				"name" => $this->name,
				"course_id" => $this->course_id,
				"syllabus" => $this->syllabus,
				"staff_id" => $this->staff_id
			), "idcourse_profile = :cid", array(":cid" => $this->idcourse_profile));
	}

	/**
	 *	Delete an instance of the Course Profile object in the datastore
	 *
	 *	@param	$cpid	Course Profile ID
	 *	@param	$db		PDOObject
	 **/
	public static function Delete($cpid, $db) {
		return $db->delete("course_profile", "idcourse_profile = :cc", array(":cc" => $cpid));
	}

	/**
	 *	Delete the course profile with Staff ID Check to ensure staff can delete only their course profiles
	 *
	 *	@param	$cpid		Value or Array of Course Profile IDs to delete
	 *	@param	$staffid	Staff ID (PK of Staff) who is the owner of these Course profiles
	 *
	 *	@return	TRUE		When the  $cpid is an array and it has executed fine
	 *			1			If the $cpid is a value, and it has executed fine. 
	 *			FALSE		In case of an error
	 **/
	public static function DeleteByStaff($cpid, $staffid, $db) {
		if(is_array($cpid)) {
			// Loop over all the array values and delete them one by one
			foreach($cpid as $cid) {
				$return = $db->delete("course_profile", "idcourse_profile = :cc and staff_id = :sid", array(":cc" => $cid, ":sid" => $staffid));

				// Have to find a better way to do this
				if(is_object($return) && get_class($return) == "PDOException")	return FALSE;
			}
			return TRUE;
		} else {
			$r = $db->delete("course_profile", "idcourse_profile = :cc and staff_id = :sid", array(":cc" => $cpid, ":sid" => $staffid));

			if(!(is_object($r) && get_class($r) == "PDOException")) return 1;
			else return FALSE;
		}
	}

	/**
	 *	Load and update the instance of the object in the datastore from the $_POST array
	 *
	 *	@param	$cp		$_POST Array value
	 *	@param	$db		PDOObject
	 *
	 *	@return	1				If successful, else 
	 *			PDOException	Object
	 **/
	public static function LoadAndUpdate($cp, $db, &$course_object = null) {
		extract($cp);

		$cprofile = new CourseProfile;
		$cprofile->idcourse_profile = $idcourse_profile;
		$cprofile->name = $name;
		$cprofile->course_id = $course_id;
		$cprofile->staff_id = $staff_id;
		if(isset($syllabus)) $cprofile->syllabus = $syllabus;

		$r = $cprofile->update($db);
		
		$course_object = $cprofile;
		
		return $r;
	}

	/**
	 *	Load and Save the current instance of the object. Generally to be used while creating the Model Object in the system.
	 *
	 *	@param	$cp Array of Model properties
	 *	
	 *	@return	1 If successful, PDOException Object
	 **/
	public static function LoadAndSave($cp, $db, &$course_object = null) {
		extract($cp);

		// Check if the Staff has already created a Course Profile for the Course
		$staff_cps = $db->select("course_profile", "course_id = :cid and staff_id = :sid", array(":cid" => $course_id, ":sid" => $staff_id));
		if(count($staff_cps) > 0) {
			// Course Profile already exist for the given course for the staff
			return false;
		}
		
		$cprofile = new CourseProfile;
		$cprofile->name = $name;
		$cprofile->course_id = $course_id;
		$cprofile->staff_id = $staff_id;
		if(isset($syllabus)) $cprofile->syllabus = $syllabus;

		
		$r = $cprofile->save($db);
		
		$course_object = $cprofile;
		
		return $r;
	}

	/**
	 *	Add the students to the current course profile
	 *
	 *	@param	$student	Student(s) registernumber to add 
	 *	@return	number of students successfully added
	 **/
	public function addStudent($students, $db, &$added_reg_nos = null) {
		$added_reg_nos = array();
		if(is_array($students)) {
			$numberOfStudentsInserted = 0;
			
			/**
			 *	@TODO 	This method of batch inserting the data is not sercure and a good practice.
			 *			Need to use Transactioons to maintain consistency in the datastore. 
			 **/
			// Array of registeration numbers to add
			foreach($students as $student) {
				$r = $db->insert("cp_has_student", array(
												"cp_id" => $this->idcourse_profile,
												"idstudent" => $student
											));

				if(is_object($r) && get_class($r) == "PDOException") {
					error_log($cia_marks_status->getMessage());
					continue;	// Need to use transactions to revert the datastore
				}
				
				// Now Create a record in cia_marks table
				$cia_marks = new CIAMarks;
				$cia_marks->assignment = NULL;
				$cia_marks->mark_1 = NULL;
				$cia_marks->mark_2 = NULL;
				$cia_marks->mark_3 = NULL;
				$cia_marks->cp_id = $this->course_profile;
				$cia_marks->student_id = $student;
				$cia_marks_status = $cia_marks->save($db);

				if(is_object($cia_marks_status) && get_class($cia_marks_status) == "PDOException") {
					error_log($cia_marks_status->getMessage());
					continue;	// Need to use transactions to revert the datastore
				}
				$numberOfStudentsInserted++;
				$added_reg_nos[] = $student;
			}

			// Return the number of students added to the system
			return $numberOfStudentsInserted;
		} else {
			// Add a single student to the course profile
			$r = $db->insert("cp_has_student", array(
											"cp_id" => $this->idcourse_profile,
											"idstudent" => $students
										));

			// Make sure the insert was successful
			if((is_object($r) && get_class($r) == "PDOException")) {
				trigger_error($cia_marks_status->getMessage());
				return 0;
			}

			// Now Create a record in cia_marks table
			$cia_marks = new CIAMarks;
			$cia_marks->assignment = NULL;
			$cia_marks->mark_1 = NULL;
			$cia_marks->mark_2 = NULL;
			$cia_marks->mark_3 = NULL;
			$cia_marks->cp_id = $this->course_profile;
			$cia_marks->student_id = $student;
			$cia_marks_status = $cia_marks->save($db);

			if(is_object($cia_marks_status) && get_class($cia_marks_status) == "PDOException") {
				trigger_error($cia_marks_status->getMessage());
				return 0;	// Need to use transactions to revert the datastore
			}
			
			$added_reg_nos[] = $students;
			return 1;
		}
	}
	
	/**
	 *	Remove the students from the current course profile
	 *
	 *	@param	$students	Student(s) registernumber to delete
	 *	@return	Number of students deleted
	 **/
	public function removeStudent($students, $db) {
		if(is_array($students)) {
			$numberOfStudentsInserted = 0;
			// Array of registeration numbers to add
			foreach($students as $student) {
				$r = $db->delete("cp_has_student", "cp_id = :cpid and idstudent = :sid",array(
												":cpid" => $this->idcourse_profile,
												":sid" => $student
											));

				if((is_object($r) && get_class($r) == "PDOException")) continue;
				
				$delete_status = CIAMarks::Delete($student, $this->idcourse_profile, $db);
				if((is_object($delete_status) && get_class($delete_status) == "PDOException")) continue;

				$numberOfStudentsInserted++;
			}

			// Return the number of students added to the system
			return $numberOfStudentsInserted;
		} else {
			// Add a single student to the course profile
			$r = $db->delete("cp_has_student", "cp_id = :cpid and idstudent = :sid",array(
										":cpid" => $this->idcourse_profile,
										":sid" => $students
									));
			if((is_object($r) && get_class($r) == "PDOException")) return 0;

			$r = CIAMarks::Delete($students, $this->idcourse_profile, $db);
			if((is_object($r) && get_class($r) == "PDOException")) return 0;
			
			// Make sure the insert was successful
			return 1;
		}
	}
	
	/**
	 *	Get all the students attached with the current Course Profile
	 *
	 *	@param	$db		PDOObject
	 *
	 *	@return	Array of Students with idstudent, name, cpid
	 **/
	public function getStudents($db) {
		$list = $db->run("select s.idstudent as idstudent, s.name as name, cp.idcourse_profile as cpid from student s, course_profile cp, cp_has_student chs where chs.idstudent = s.idstudent and chs.cp_id = cp.idcourse_profile and cp.idcourse_profile = :cpid order by s.idstudent", array(":cpid" => $this->idcourse_profile));
		
		/**
		 *	@TODO May be we can get the register numbers and get the Student Object using the Student::load() and return array of Students objects.
		 *	Wouldn't that be more interactive to show more details in the UI?
		 **/
		// Return only the students register number
		return $list;
	}
	
	/**
	 *	Load the current instance of the object from the datastore
	 *
	 *	@param	$cpid	Course Profile ID
	 *	@param	$db		PDOObject
	 *
	 *	@return	An instance of CourseProfile
	 **/
	public static function load($cpid, $db) {
		$r = $db->select("course_profile", "idcourse_profile = :cpid", array(":cpid" => $cpid));

		if((is_object($r) && get_class($r) == "PDOException")) return FALSE;
		else {
			extract($r[0]);

			$cprofile = new CourseProfile;
			$cprofile->idcourse_profile = $idcourse_profile;
			$cprofile->name = $name;
			$cprofile->course_id = $course_id;
			$cprofile->staff_id = $staff_id;
			$cprofile->syllabus = $syllabus;

			return $cprofile;
		}
	}

	/**
	 *	Search the Model entities in the datastore
	 *
	 *	@param	$db			PDOObject
	 *	@param	$condition	Search Condition 
	 *	@param	$bind		Array of bound values used in $condition
	 *
	 *	@return	Array of Model entities matching the $condition
	 **/
	public static function search($db, $condition = '1=1', $bind = array()) {
		return $db->select("course_profile", $condition, $bind);
	}	
}

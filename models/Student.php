<?php

/**
 *	Student Model class for representing the Student entity
 *
 *	@date 07/11/2011
 *	@author Team Webnaplo
 **/
class Student {
	public $idstudent;
	public $address;
	public $current_semester;
	public $email;
	public $is_blocked;
	public $mobile;
	public $name;
	public $password;
	public $year;
	public $class_id;
	
	/**
	 * Implements the ActiveRecord#save design pattern for the student entity
	 *
	 * @TODO Add automatic #update to save()
	 **/
	public function save($db) {
		return $db->insert("student", array(
					"idstudent" => $this->idstudent,
					"address" => $this->address,
					"current_semester" => $this->current_semester,
					"email" => $this->email,
					"is_blocked" => $this->is_blocked,
					"mobile" => $this->mobile,
					"name" => $this->name,
					"password" => $this->password,
					"year" => $this->year,
					"class_id" => $this->class_id
				));
	}

	/**
	 * Implements the ActiveRecord#update design pattern for the student entity
	 *
	 * @TODO Add automatic $this->save if not present
	 **/
	public function update($db) {		
		return $db->update("student", array(
					"address" => $this->address,
					"current_semester" => $this->current_semester,
					"email" => $this->email,
					"is_blocked" => $this->is_blocked,
					"mobile" => $this->mobile,
					"name" => $this->name,
					"password" => $this->password,
					"year" => $this->year,
					"class_id" => $this->class_id
			), "idstudent = :cid", array(":cid" => $this->idstudent));
	}

	/**
	 *	Get more information about the student
	 *	
	 *	More information includes - 
	 *		1. dname		-	Department Name
	 *		2. iddept		-	Department ID
	 *		3. pname		-	Programme Name
	 *		4. idprogramme 	-	Programme ID
	 *		5. cname		-	Class / Section Name
	 *		6. idclass		-	Class / Section ID
	 *
	 *	@param	$db		PDOObject
	 *
	 *	@return	Array of properties as described above
	 *			FALSE on error or if the student does not exist
	 **/
	public function getMore($db) {
		$dept = $db->run("select d.name as dname, d.iddept as iddept, p.name as pname, p.idprogramme as idprogramme, c.idclass as idclass, c.name as cname from student s, dept d, class c, programme p where s.idstudent = :reg and s.class_id = c.idclass and d.iddept = p.dept_id and c.programme_id = p.idprogramme", array(":reg" => $this->idstudent));
	
		// Return FALSE on error
		if((is_object($dept) && get_class($dept) == "PDOException")) return FALSE;
		
		// Check if the student exist and valid
		if(count($dept) > 0) return $dept[0];
		else return FALSE;
	}
	
	/**
	 *	Lodas the array value from the param to a $Student Object and updates it
	 **/
	public static function LoadAndUpdate($student, $db) {
		extract($student);

		$student = Student::load($idstudent, $db);
		if(isset($idstudent))			$student->idstudent = $idstudent;
		if(isset($address))				$student->address = $address;
		if(isset($current_semester))	$student->current_semester = $current_semester;
		if(isset($email))				$student->email = $email;
		if(isset($is_blocked))			$student->is_blocked = $is_blocked;
		if(isset($mobile))				$student->mobile = $mobile;
		if(isset($name))				$student->name = $name;
		if(isset($password))			$student->password = $password;
		if(isset($year))				$student->year = $year;
		if(isset($class_id)) 			$student->class_id = $class_id;
		
		return $student->update($db);
	}
	
	/**
	 *	Load an instance of the Student model from the database based on the register number
	 *
	 *	@param	$studentId	Register number of the student
	 *	@param	$db			PDOObject
	 *
	 *	@return	Current Student instance on success
	 *			FALSE on failure
	 **/
	public static function load($studentId, $db) {
		$isStudentAvailable = $db->select("student", "idstudent = :reg", array(":reg" => $studentId));
		
		if(count($isStudentAvailable) > 0) {
			// Student Available
			extract($isStudentAvailable[0]);
			$student = new Student;
			
			if(isset($idstudent))			$student->idstudent = $idstudent;
			if(isset($address))				$student->address = $address;
			if(isset($current_semester))	$student->current_semester = $current_semester;
			if(isset($email))				$student->email = $email;
			if(isset($is_blocked))			$student->is_blocked = $is_blocked;
			if(isset($mobile))				$student->mobile = $mobile;
			if(isset($name))				$student->name = $name;
			if(isset($password))			$student->password = $password;
			if(isset($year))				$student->year = $year;
			if(isset($class_id)) 			$student->class_id = $class_id;
			
			return $student;
		} else {
			return FALSE;
		}
	}

	public static function LoadAndSave($student, $db) {
		extract($student);
		
		$student = new Student;
		if(isset($class_id)) 			$student->class_id = $class_id;
		if(isset($year))				$student->year = $year;
		if(isset($idstudent))			$student->idstudent = $idstudent;
		if(isset($name))				$student->name = $name;
		if(isset($email))				$student->email = $email;
		if(isset($address))				$student->address = $address;
		if(isset($mobile))				$student->mobile = $mobile;
		if(isset($current_semester))	$student->current_semester = $current_semester;
		
		$student->is_blocked = 0;
		$student->password = "src";
		
		return $student->save($db);
	}

	/**
	 * Get the list of courses, for a given student 
	 **/
	public static function getCoursesList($reg_no, $db) {
		$query = "select cs.course_code,cs.course_name,cs.credits from student s,class c,programme p,course cs where s.idstudent=:reg s.class_id=c.idclass and c.programme_id=p.idprogramme and cs.programme_id=p.idprogramme;";
		
		return $db->run($query, array(":reg" => $reg_no));
		
	}
	
	/**
	 * Get the Attendance for a given student
	 **/
	public static function getAttendance($reg_no, $db) {
		$query = "select a.date, a.is_present, c.course_name, c.course_code from attendance a, timetable t, course_profile cp, course c where a.idstudent = :reg  and a.timetable_id = t.idtimetable and t.cp_id = cp.idcourse_profile and cp.course_id = c.idcourse order by a.date desc";
		
		return $db->run($query, array(":reg" => $reg_no));
	}

	/**
	 * Get the CIA Marks for a given student
	 **/
	public static function getCIAMarks($cia_type,$reg_no, $db) {
		$ciatype = 'mark_1';
		switch($cia_type) {
			case 1:
				$ciatype = 'mark_1';
				break;
			case 2:
				$ciatype = 'mark_2';
				break;
			case 3:
				$ciatype = 'mark_3';
				break;
			case 4:
				$ciatype = 'assignment';
				break;
			default:
				$ciatype = 'mark_1';
		}
		
		$query = "select cm.$ciatype, c.course_code, c.course_name from cia_marks cm, course c, course_profile cp where cm.idstudent = :reg and cp.course_id = c.idcourse";
		
		return $db->run($query, array(":reg" => $reg_no));
	}
	
	// @todo Improvise the code
	public static function getTimetable($reg_no, $db)  {
		$query = "select c.course_name, c.course_code, t.days_of_week, t.hour_of_day from timetable t, course c, class cl, course_profile cp, student s where s.idstudent = :reg and s.class_id = cl.idclass and cp.class_id = cl.idclass and c.idcourse = cp.course_id and t.cp_id = cp.idcourse_profile ";
		
		return $db->run($query, array(":reg" => $reg_no));
	}
	
	/**
	 * Get the Profile details of the student
	 **/
	public static function getProfile($reg_no, $db)  {
		$query = "select name, email, address, mobile, address, is_blocked, year, class_id from Student where idstudent=:reg;";
		
		return $db->run($query, array(":reg" => $reg_no));
	}
		
	/**
	 * Get the student profile block status
	 **/
	public function getBlockStatus($db) {
		$query = "select s.is_blocked from student s where s.idstudent = :reg;";
		
		return $db->run($query, array(":reg" => $this->idstudent));
	}
	
	/**
	 * Unlock the student profile
	 *
	 * @scope Admin and Dataentry only
	 **/
	public static function unblock($uid, $db) {
		$query = "update student set is_blocked = '0' where idstudent=:uid";
		
		return $db->run($query, array(":uid" => $uid));
	}

	/**
	 * Block the student profile
	 *
	 * @scope Admin and Dataentry only
	 **/
	public static function block($uid, $db) {
		$query = "update student set is_blocked = '1' where idstudent = :uid;";
		
		return $db->run($query, array(":uid" => $uid));
	}

	/**
	 * Delete the Student in the Student Model
	 **/
	public static function Delete($id, $db) {
		return $db->delete("student", "idstudent = :sid", array(":sid" => $id));
	}
	
	/**
	 *	Import the Student List from a XLS/XLSX/CSV/ODS file
	 **/
	public static function Import($filename, $class_id, $db) {
		// This function requires us to include PHPExcel library which should be included before callng this function
		// Read from any of the supported files directly
		$objPHPExcel = PHPExcel_IOFactory::load($filename);

		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		// Contains the list of ids which will be generated upon inserting into the database
		$student_insert_ids = array();
		$file_column_mapping = array('A' => 'name', 'B' => 'registernumber', 'C' => 'year', 'D' => 'semester', 'E' => 'mobile', 'F' => 'email', 'G' => 'address');
		$batch_errors = array();
		
		// Read through all the rows of the file
		foreach($rowIterator as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(true);

			//skip first row -- Since its the heading
			if(1 === $row->getRowIndex()) {
				foreach($cellIterator as $cell) {
					if('name' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'name';
					} else if('registernumber' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'registernumber';
					} else if('year' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'year';
					} else if('semester' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'semester';
					} else if('mobile' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'mobile';
					} else if('email' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'email';
					} else if('address' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'address';
					}
				}
				continue;
			}

			// Getting zero-based row index
			$rowIndex = $row->getRowIndex() - 2;
			$array_data[$rowIndex] = array('name' => '', 'registernumber' => '', 'year' => '', 'semester' => '', 'mobile' => '', 'email' => '', 'address' => '');
			
			// Get the data from the sheet
			foreach($cellIterator as $cell) {
				$prop = $file_column_mapping[$cell->getColumn()];
				$array_data[$rowIndex][$prop] = $cell->getValue();
			}
			
			// Insert the Student Data into DB
			// Map the Excel File fields to Student Model fields
			$student_post_data = array(
									'class_id' => $class_id, // Got as an Input from the form
									'year' => $array_data[$rowIndex]['year'],
									'idstudent' => $array_data[$rowIndex]['registernumber'],
									'name' => $array_data[$rowIndex]['name'],
									'email' => $array_data[$rowIndex]['email'],
									'address' => $array_data[$rowIndex]['address'],
									'mobile' => $array_data[$rowIndex]['mobile'],
									'current_semester' => $array_data[$rowIndex]['semester']
								);
			
			$r = Student::LoadAndSave($student_post_data, $db);
			
			if(!is_object($r)) $student_insert_ids[] = $array_data[$rowIndex]['registernumber'];
			else if(is_object($r) && get_class($r) == "PDOException") {
				// Save the Error message associated with all the error register number
				$reg = $array_data[$rowIndex]['registernumber'];
				$batch_errors[$reg] = $r->getMessage();
			}
		}	// End of processing all the rows of the file
		
		return $batch_errors;
	}
}


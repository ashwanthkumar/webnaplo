<?php

/**
 *	Model Class for Staff
 **/
class Staff {

	public $idstaff;
	public $address;
	public $designation;
	public $email;
	public $is_blocked;
	public $mobile;
	public $name;
	public $password;
	public $staff_id;
	public $dept_iddept;
	
	/**
	 *	Returns the list of course profiles that the current staff takes
	 *
	 *	@param	$staffid	StaffId for whom you wish to get the information
	 *	@param	$db			PDOObject Reference
	 *
	 *	@return List of Course profiles for the staff id
	 **/
	public static function SgetCourseProfiles($staffid, $db) {
		return $db->run("select cp.name as cpname, cp.idcourse_profile as idcourse_profile, c.course_name as cname from course_profile cp, course c where cp.course_id = c.idcourse and cp.staff_id = :sid", array(":sid" => $staffid));
	}
	
	/**
	 *	Non-static version of get Course Profiles
	 **/
	public function getCourseProfiles($db) {
		return Staff::SgetCourseProfiles($this->idstaff, $db);
	}
	
	/**
	 *	Clear the Timetable of the staff member. Generally used when updating the timetable, as re-creating is much easier than updating
	 *
	 *	@param	$s_id	Staff ID
	 *	@param	$db		PDO Object
	 *
	 *	@return TRUE if the operation completed successfully, else FALSE
	 **/
	public static function SclearTimetable($s_id, $db) {
		$affected_rows = $db->run("delete from timetable where cp_id in (select idcourse_profile from course_profile where staff_id = :sid)", array(":sid" => $s_id));
		
		return (is_object($affected_rows) && get_class($affected_rows) == "PDOException") ? true : false;
	}
	
	/**
	 * Non-static version of Staff::clearTimetable()
	 **/
	public function clearTimetable($db) {
		return Staff::SclearTimetable($this->staff_id, $db);
	}
	
	/**
	 *	Get the timetable for the staff members
	 *
	 *	@param	$staffid	StaffId for whom you wish to recieve the timetable
	 *	@param	$db			PDOObject Reference
	 *
	 *	@return Get the current timetable views for a particular staff
	 **/
	public static function SgetTimetable($staffid, $db) {
		return $db->run("select hour_of_day, days_of_week, cp_id from timetable where cp_id in (select idcourse_profile from course_profile where staff_id = :sid)", array(":sid" => $staffid));
	}
	
	/**
	 *	Non-Static version of getTimetable()
	 **/
	public function getTimetable($db) {
		return Staff::SgetTimetable($this->staff_id, $db);
	}
	
	/**
	 *	Loads the instance of the staff member and saves its instance
	 *
	 *	@return	FALSE if staff member already exist, 
	 *	@see Staff->save() for other return values
	 **/
	public static function LoadAndSave($staff, $db, &$staff_object = null) {
		extract($staff);
		
		$staffCount = $db->select("staff", "staff_id = :sid", array(":sid" => $staff_id));
		if(count($staffCount) > 0) return false;
		
		$staff = new Staff;
		$staff->name = $name;
		$staff->designation = $designation;
		$staff->dept_id = $dept_id;
		$staff->staff_id = $staff_id;
		$staff->email = $email;
		$staff->mobile = $mobile;
		$staff->address = $address;
		
		$staff->is_blocked = false;
		$staff->password = "src";
		
		$r = $staff->save($db);
		
		$staff_object = $staff;
		
		$r;
	}
	
	/**
	 *	Returns a valid instance of the current Staff Object based on the StaffID specified
	 *
	 *	@param	$staffid	Staff ID
	 *	@param	$db			PDOObject Reference
	 *
	 *	@return	Valid Staff object if Staff ID is correct, else FALSE
	 **/
	public static function load($staffid, $db) {
		// Select the staff member based on the type of staff id
		if(is_numeric($staffid)) $staffObject = $db->select("staff", "idstaff = :sid", array(":sid" => $staffid));
		else $staffObject = $db->select("staff", "staff_id = :sid", array(":sid" => $staffid));
		
		if(count($staffObject) < 1) return false;
		
		// extract the staff properties as variables
		extract($staffObject[0]);
		
		$staff = new Staff;
		$staff->idstaff = $idstaff;
		$staff->name = $name;
		$staff->designation = $designation;
		$staff->dept_id = $dept_id;
		$staff->staff_id = $staff_id;
		$staff->email = $email;
		$staff->mobile = $mobile;
		$staff->address = $address;
		
		$staff->is_blocked = $is_blocked;
		$staff->password = $password;
		
		return $staff;
	}
	
	/**
	 *	Save the current instance of the Staff Model to the database
	 *
	 *	@return		 		1 			If operation is successful 
	 *	@return		PDOExceptionObject 	If there is an Error
	 **/
	public function save($db) {
		$r= $db->insert("staff", array (
			"name" => $this->name,
			"designation" => $this->designation,
			"dept_id" => $this->dept_id,
			"staff_id" => $this->staff_id,
			"email" => $this->email,
			"mobile" => $this->mobile,
			"address" => $this->address,
			"is_blocked" => $this->is_blocked,
			"password" => $this->password
		));
		if(is_object($r) && get_class($r) == "PDOException") return $r;
		
		$this->idstaff = $db->lastInsertId();
		return $r;
	}
	
	/**
	 *	Get the course profile of the staff member. This method is using when Editing a course profile 
	 *
	 *	@param	$cpid	Course Profile ID
	 *	@param	$db		PDOObject
	 *
	 *	@return	Array of following properties
	 *			-> course_id
	 *			-> syllabus
	 *			-> name (CourseProfile Name)
	 *			-> course_name
	 *			-> course_code
	 **/
	public function getCourseProfile($cpid, $db) {
		$course_profile = $db->run("select cp.course_id as course_id, cp.syllabus as syllabus, cp.name as cpname, c.course_name, c.course_code from course_profile cp, course c where cp.idcourse_profile = :cip and cp.course_id = c.idcourse and cp.staff_id = :sid", array(":cip" => $cpid, ":sid" => $this->idstaff));
		
		if(is_object($course_profile) && get_class($course_profile) == "PDOException") {
			return false;
		}
		
		if(count($course_profile) < 1) return false;
		else return $course_profile[0];
	}
	
	/**
	 *	Get the pending attendance for a given staff member to be posted
	 *
	 *	@param	$staffid	Staff ID
	 *	@param	$db			PDOObject
	 *
	 *	@return Pending attendance List
	 **/
	public static function SgetPendingAttendance($staffid, $db) {
		date_default_timezone_set("Asia/Calcutta");
		
		$pending = array();
		
		$cpListQuery = "select  * from course_profile where staff_id = (select idstaff from staff where staff_id = :sid)";
		$cpList = $db->run($cpListQuery, array(":sid" => $staffid));
		
		foreach($cpList as $cp) {
			$getAttendanceListQuery = "select at.`date` from attendance at where at.timetable_id in (select idtimetable from timetable where cp_id = :cpid) group by at.`date` order by `date` desc ;";
			
			$postedAttendance = $db->run($getAttendanceListQuery, array(":cpid" => $cp['idcourse_profile']));

			if(is_object($postedAttendance) && get_class($postedAttendance) == "PDOException") {
				flash('warning', $postedAttendance->getMessage());
				print_r($postedAttendance->getMessage());
				return false;
			}

			$postedDays = array();
			
			// print_r($postedAttendance);
			foreach($postedAttendance as $posted) {
				$postedDays[] = $posted['date'];
			}
			
			$workingDays = System::getWokingDaysTillNow($db);
			
			// Find the tentative number of pending days
			$tempPending = array_diff($workingDays, $postedDays);
			
			$getTimeTableQuery = "select * from timetable where cp_id = :cpid";
			$timeTable = $db->run($getTimeTableQuery, array(":cpid" => $cp['idcourse_profile']));
			// print_r($timeTable);
			$days_of_week = array();
			$days_hour_tt = array();
			foreach($timeTable as $tt) {
				$days_of_week[] = $tt['days_of_week'];
				$days_hour_tt[$tt['days_of_week']][] = $tt['hour_of_day'];
			}
			
			$pendingDay = array();
			$pendingDay['name'] = $cp['name'];
			$pendingDay['cp_id'] = $cp['idcourse_profile'];
			// echo $cp['name'] . "<br />";
			
			foreach($tempPending as $tp) {
				$day_num = date('N', strtotime($tp));
				// echo $day_num . "<br>";
				if(in_array($day_num, $days_of_week)) {
					foreach($days_hour_tt[$day_num] as $hour) {
						// echo "Pending date - " . date('Y-m-d', strtotime($tp)) . " -- $hour - hour.<br>";
						$pendingDay['name'] = $cp['name'];
						$pendingDay['date'] = date('Y-m-d', strtotime($tp));
						$pendingDay['hour'] = $hour;
						
						// Moving this outside the loop decreases the resoulution of data and causes a lot of abstraction
						$pending[] = $pendingDay;
					}
				}
			}
			
		}
		
		return $pending;
	}
	
	/**
	 *	Non-static version of getPendingAttendance()
	 **/
	public function getPendingAttendance($db) {
		return Staff::SgetPendingAttendance($this->staff_id, $db);
	}
	
	public static function getStudentListForCourseProfile($cp_id,$s_id) {
		// select s.idstudent from staff s ,student stu,course_profile c_p,class c where s.staff_id=$s_id and c_p.staff_idstaff=s.idstaff an c_p.class_iclass=c.idclass and stu.class_idclass=c.iclass;
	}
		
	
	public static function getPendingCIA() {
		// select cs.name from cia_marks cia,staff s,course_profile cs where s.staffid=$s_id and marks_1=NULL or marks_2=NULL or marks_3=NULL or assignment=NULL;
	} 
		
	public static function getLackStatusForCourseProfile($idcourse_profile) {
			// set the attendance for the student 
	}
		
	public static function getLackStatus() {
			// set the attendance for the student 
	}
	
	/**
	 *	Imports the Staff List to the datastore. Supported file types are - 
	 *				-->	XLSX
	 *				-->	XLS
	 *				-->	CSV
	 *
	 *	@linkedTestId	ReadStaffExcel
	 *	
	 *	@param	$filename	Filename (with full path) to read from
	 *	@param	$dept		Department where the current staff list belongs
	 *	@param	$db			PDOObject
	 **/
	public static function Import($filename, $dept, $db) {
		// Read from any of the supported files directly
		$objPHPExcel = PHPExcel_IOFactory::load($filename);

		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		// Contains the list of ids which will be generated upon inserting into the database
		$staff_insert_ids = array();
		$file_column_mapping = array('A' => 'staffid', 'B' => 'name', 'C' => 'address', 'D' => 'designation', 'E' => 'mobile', 'F' => 'email');
		$batch_errors = array();
		
		foreach($rowIterator as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(true);

			//skip first row -- Since its the heading
			if(1 === $row->getRowIndex()) {
				foreach($cellIterator as $cell) {
					if('name' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'name';
					} else if('staffid' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'staffid';
					} else if('designation' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'designation';
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
			$array_data[$rowIndex] = array('name' => '', 'staffid' => '', 'designation' => '', 'mobile' => '', 'email' => '', 'address' => '');
			
			// Get the data from the sheet
			foreach($cellIterator as $cell) {
				$prop = $file_column_mapping[$cell->getColumn()];
				$array_data[$rowIndex][$prop] = $cell->getValue();
			}
			
			// Insert the Staff Data into DB
			// Map the Excel File fields to Staff Model fields
			$staff_post_data = array(
									'name' => $array_data[$rowIndex]['name'],
									'designation' => $array_data[$rowIndex]['designation'], 
									'dept_id' => $dept, // Department value got from the form
									'staff_id' => $array_data[$rowIndex]['staffid'],
									'email' => $array_data[$rowIndex]['email'],
									'mobile' => $array_data[$rowIndex]['mobile'],
									'address' => $array_data[$rowIndex]['address']
								);
			
			$r = Staff::LoadAndSave($staff_post_data, $db);
			
			if(!is_object($r)) $staff_insert_ids[] = $array_data[$rowIndex]['staffid'];
			else {
				$staffId = $array_data[$rowIndex]['staffid'];
				$batch_errors[$staffId] = $r->getMessage(); 
			}
		}
		// Return the batch errors if any
		return $batch_errors;
	}
		
	public static function getBlockStatus() {
		// select s.name,s.is_blocked from staff s;
	}
	
	/**
	 *	Delete the instance of the staff from the system. There cannnot be non-static version of this function, as it brings about a dependency of managing the user access at the application. Hence this method is made only Static and need to be accessed after managing all the application level user access.
	 *
	 *	@param	$staffid	Staff ID to delete
	 *	@param	$db			PDOObject Reference
	 **/
	public static function Delete($staffid, $db) {
		return $db->delete("staff", "staff_id = :staffid", array(":staffid" => $staffid));
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
		return $db->select("staff", $condition, $bind);
	}

}

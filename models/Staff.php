<?php

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
		
	public static function getCourseProfiles($staff, $db) {
		$query = "select c_p.name from staff s,course_profile c_p where s.staff_id='" . $s_id . "' and c_p.staff_idstaff = c.idstaff;";
		return $db->run($query);
	}
		
	public static function getTimeTable($s_id) {
		// $query = "select c_p.name,t.days_of_week,t.hours_of_day from staff s,course_profile c_p,timetable t where s.staff_id='$s_id' c_p.staff_idstaff=c.idstaff t.cp_id=c_p.idcp;";
		return $db->run($query);
	}
	
	public static function LoadAndSave($staff, $db) {
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
		
		return $staff->save($db);
	}
	
	public function save($db) {
		return $db->insert("staff", array (
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
	}
	
	public static function getPendingAttendance($staffid, $db) 
	{
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
	
	public static function getStudentListForCourseProfile($cp_id,$s_id) 
	{
		// select s.idstudent from staff s ,student stu,course_profile c_p,class c where s.staff_id=$s_id and c_p.staff_idstaff=s.idstaff an c_p.class_iclass=c.idclass and stu.class_idclass=c.iclass;
	}
		
	
	public static function getPendingCIA() 
	{
		// select cs.name from cia_marks cia,staff s,course_profile cs where s.staffid=$s_id and marks_1=NULL or marks_2=NULL or marks_3=NULL or assignment=NULL;
	} 
		
	public static function getLackStatusForCourseProfile($idcourse_profile) {
			// set the attendance for the student 
		}
		
	public static function getLackStatus() {
			// set the attendance for the student 
		}
		
	public static function importStaffList() {
			// import stafflist
		}
		
	public static function getBlockStatus() 
	{
		// select s.name,s.is_blocked from staff s;
	}
		
	public static function Delete($staffid, $db) {
		return $db->delete("staff", "staff_id = :staffid", array(":staffid" => $staffid));
	}
}

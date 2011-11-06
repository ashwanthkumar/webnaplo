
<?php

	class Staff {
		
	private $idstaff;
		public function getIdstaff() 
		{ 
		return $this->idstaff;
		}
		public function setIdstaff($idstaff)
		{
			$this->idstaff = $idstaff;
		}
		
	private $address;
		public function getAddress()
		{
		return $this->address;
		}
		public function setAddress($address)
		{
			$this->address = $address;
		}
		
	private $designation;
		public function getDesignation()
		{
		return $this->designation;
		}
		public function setDesignation($designation)
		{
			$this->designation = $designation;
		}
		
	private $email;
		public function getEmail()
		{
		return $this->email;
		}
		public function setEmail($email)
		{
			$this->email = $email;
		}
		
	private $is_Blocked;
		public function getIsBlocked()
		{
		return $this->is_Blocked;
		}
		public function setIsBlocked($is_Blocked)
		{
			$this->is_Blocked = $is_Blocked;
		}
		
	private $mobile;
		public function getmobile()
		{
		return $this->mobile;
		}
		public function setmobile($mobile)
		{
			$this->mobile = $mobile;
		}
		
	private $name;
		public function getname()
		{
		return $this->name;
		}
		public function setname($name)
		{
			$this->name = $name;
		}
		
	private $password;
		
		public function getpassword()
		{
		return $this->password;
		}
		public function setpassword($password)
		{
			$this->password = $password;
		}
			
	private $staff_id;
		
		public function getStaff_id()
		{
		return $this->staff_id;
		}
		public function setStaff_idr($staff_id)
		{
			$this->staff_id = $staff_id;
		}
		
	private $dept_iddept;
		
		public function getDept_iddept()
		{
		return $this->dept_iddept;
		}
		public function setDept_iddept($dept_iddept)
		{
			$this->dept_iddept = $dept_iddept;
		}
		
		
		
	public static function getCourse_Profile($s_id) 
	{
		// select c_p.name from staff s,course_profile c_p where s.staff_id="$s_id" and c_p.staff_idstaff=c.idstaff;
	}
		
	public static function getTimeTable($s_id)
	{
		// select c_p.name,t.days_of_week,t.hours_of_day from staff s,course_profile c_p,timetable t where s.staff_id="$s_id" c_p.staff_idstaff=c.idstaff t.cp_id=c_p.idcp;
	}
	
	public static function getPendingAttendance() 
	{
		// select a.date,cs.name from attendance a,staff s,timetable t,courseprofile cs where s.staffid=$s_id and is_Present=false and a.timetable_idtimetable=t.idtimetable an t.cp_id = cs.idcp;
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
		// select s.name,s.is_Blocked from staff s;
	}
		
		
	public static function unblock_User($uid) 
	{
		// update staff set is_blocked=false where staff_id=uid;
	}
	
	public static function block_user($uid) {
		// update staff set is_blocked = true where staff_id = uid;
	}
	
	public static function Delete($staffid, $db) {
		return $db->delete("staff", "staff_id = :staffid", array(":staffid" => $staffid));
	}
}

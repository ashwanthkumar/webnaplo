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
	 *	Lodas the array value from the param to a $Student Object and updates it
	 **/
	public static function LoadAndUpdate($student, $db) {
		extract($student);

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
		
		return $student->update($db);
	}

	public static function LoadAndSave($student, $db) {
		extract($student);
		
		print_r($student);

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
	
	
	public static function editProfile( $address, $phone, $mail){
		// To modify the student profile
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
}


<?php

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
	
	public function save($db) {
		return $db->insert("student", array(
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
	
	public static function LoadAndUpdate($student, $db) {
		extract($student);

		$student = new Student;
		$student->idstudent = $idstudent;
		$student->address = $idcourse;
		$student->current_semester = $credits;
		$student->email = $coursecode;
		$student->is_blocked = $coursename;
		$student->mobile = $pgm_id;
		$student->name = $pgm_id;
		$student->password = $pgm_id;
		$student->year = $pgm_id;
		$student->class_id = $pgm_id;
		
		return $student->update($db);
	}

	public static function getCoursesList($reg_no, $db) {
		$query = "select cs.course_code,cs.course_name,cs.credits from student s,class c,programme p,course cs where s.idstudent=:reg s.class_idclass=c.idclass and c.programme_idprogramme=p.idprogramme and cs.programme_idprogramme=p.idprogramme;";
		
		return $db->run($query, array(":reg" => $reg_no));
		
	}
	
	public static function getAttendance($reg_no, $db) {
		$query = "select a.date,a,is_Present from student s,class c,programme p,course cs,course_profile c_p,timetable t,attendance a where s.idstudent=:reg and s.class_idclass=c.idclass and c.programme_idprogramme=p.idprogramme and cs.programme_idprogramme=p.idprogramme and cp.course_idcourse=c.idcourse and t.cp_id=c_p.idcp and a.timetable_idtimetable=t.idtimetable;";
		
		return $db->run($query, array(":reg" => $reg_no));
	}

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
		
		$query = "select $ciatype from student s,class c,programme p,course c,course_profile c_p,cia_marks cia where s.idstudent=:reg and s.class_idclass=c.idclass and c.programme_idprogramme=p.idprogramme and c.programme_idprogramme=p.idprogramme and c_p.course_idcourse=c.idcourse and cia.cp_id=course_profile.idcp;";
		
		return $db->run($query, array(":reg" => $reg_no));
	}
	
	public static function getTimetable($reg_no, $db)  {
		$query = "select cs.course_name,t.days_of_week,t.hour_of_day from student s,class c,programme p,course cs,course_profile c_p,timetable t where s.idstudent=:reg and s.class_idclass=c.idclass and c.programme_idprogramme=p.idprogramme and cs.programme_idprogramme=p.idprogramme and cp.course_idcourse=c.idcourse and t.cp_id=c_p.idcp;";
		
		return $db->run($query, array(":reg" => $reg_no));
	}
	
	public static function getProfile($reg_no, $db)  {
		$query = "select name, email, address, mobile, address, is_blocked, year, class_id from Student where idstudent=:reg;";
		
		return $db->run($query, array(":reg" => $reg_no));
	}
	
	
	public static function editProfile( $address, $phone, $mail){
		// To modify the student profile
	}
	
	public function getBlockStatus($db) {
		$query = "select s.is_blocked from student s where s.idstudent = :reg;";
		
		return $db->run($query, array(":reg" => $this->idstudent));
	}
	
	public static function unblock($uid, $db) {
		$query = "update student set is_blocked = '0' where student_id=:uid";
		
		return $db->run($query, array(":uid" => $uid));
	}

	public static function block($uid, $db) {
		$query = "update student set is_blocked = '1' where student_id = :uid;";
		
		return $db->run($query, array(":uid" => $uid));
	}

	public static function Delete($id, $db) {
		// $del=mysql_query("DELETE FROM Student WHERE id=$id",$connection_2);
		return $db->delete("student", "idstudent = :sid", array(":sid" => $id));
	}	
}


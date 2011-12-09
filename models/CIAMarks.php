<?php

class CIAMarks {

	public $idcia_marks;
	public $assignment;
	public $mark_1;
	public $mark_2;
	public $mark_3;		
	public $course_profile_idcourse_profile;		
	public $student_idstudent;
	
	public function save($db) {
		return $db->insert("cia_marks", array(
					"assignment" => $this->assignment,
					"mark_1" => $this->mark_1,
					"mark_2" => $this->mark_2,
					"mark_3" => $this->mark_3,
					"course_profile_idcourse_profile" => $this->course_profile_idcourse_profile,
					"student_idstudent" => $this->student_idstudent
				));		
	}
	
	public function update($db) {
		return $db->update("cia_marks", array(
					"assignment" => $this->assignment,
					"mark_1" => $this->mark_1,
					"mark_2" => $this->mark_2,
					"mark_3" => $this->mark_3,
					"course_profile_idcourse_profile" => $this->course_profile_idcourse_profile,
					"student_idstudent" => $this->student_idstudent
			), "idcia_marks = :cid", array(":cid" => $this->idcia_marks));
	}
	
	public static function Delete($student, $course, $db) {
		return $db->delete("cia_marks", "student_idstudent = :sis and course_profile_idcourse_profile = :cpid", array(":sis" => $student, ":cpid" => $course));
	}
	
}


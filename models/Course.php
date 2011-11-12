<?php

class Course{
	public $idcourse;
	public $coursecode;
	public $coursename;
	public $credits;
	public $pgm_id;
	
	public function save($db) {
		return $db->insert("course", array(
					"idcourse" => $this->idcourse,
					"course_code" => $this->coursecode,
					"course_name" => $this->coursename,
					"credits" => $this->credits,
					"programme_id" => $this->pgm_id
				));
	}
	
	public function update($db) {		
		return $db->update("course", array(
				"course_code" => $this->coursecode,
				"course_name" => $this->coursename,
				"credits" => $this->credits,
				"programme_id" => $this->pgm_id
			), "idcourse = :cid", array(":cid" => $this->idcourse));
	}
	
	public static function Delete($cid, $db) {
		return $db->delete("course", "course_code = :cc", array(":cc" => $cid));
	}
	
	public static function LoadAndUpdate($post, $db) {
		extract($post);

		$course = new Course;
		$course->idcourse = $idcourse;
		$course->credits = $credits;
		$course->coursecode = $coursecode;
		$course->coursename = $coursename;
		$course->pgm_id = $pgm_id;
		
		return $course->update($db);
	}
	
	public static function LoadAndSave($courseData, $db) {
		extract($courseData);

		$cs = $db->select("course", "course_code = :code and course_name = :name and credits = :credits and programme_id = :pgm", array(":code" => $coursecode, ":name" => $coursename, ":credits" => $credits, ":pgm" => $pgm_id));
		
		if(count($cs) > 0) return FALSE;
		
		$course = new Course;
		$course->credits = $credits;
		$course->coursecode = $coursecode;
		$course->coursename = $coursename;
		$course->pgm_id = $pgm_id;
		
		return $course->save($db);
	}
}

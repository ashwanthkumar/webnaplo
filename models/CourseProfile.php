<?php

class CourseProfile {

	public $idcourse_profile;
	public $name;
	public $class_id;
	public $course_id;
	public $staff_id;
	
	public function save($db) {
		return $db->insert("course_profile", array(
				"idcourse_profile" => $this->idcourse_profile,
				"name" => $this->name,
				"class_id" => $this->class_id,
				"course_id" => $this->course_id,
				"staff_id" => $this->staff_id
			));
	}
	
	public function update($db) {
		return $db->update("course_profile", array(
				"name" => $this->name,
				"class_id" => $this->class_id,
				"course_id" => $this->course_id,
				"staff_id" => $this->staff_id
			), "idcourse_profile = :cid", array(":cid" => $this->idcourse_profile));
	}

	public static function Delete($cpid, $db) {
		return $db->delete("course_profile", "idcourse_profile = :cc", array(":cc" => $cid));
	}

	public static function LoadAndUpdate($cp, $db) {
		extract($cp);

		$cprofile = new CourseProfile;
		$cprofile->idcourse_profile = $idcourse_profile;
		$cprofile->name = $name;
		$cprofile->class_id = $class_id;
		$cprofile->course_id = $course_id;
		$cprofile->staff_id = $staff_id;
		
		return $cprofile->update($db);
	}
	
	public static function LoadAndSave($cp, $db) {
		extract($cp);

		$cprofile = new CourseProfile;
		$cprofile->name = $name;
		$cprofile->class_id = $class_id;
		$cprofile->course_id = $course_id;
		$cprofile->staff_id = $staff_id;
		
		return $cprofile->save($db);
	}
}

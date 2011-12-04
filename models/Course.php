<?php

class Course{
	public $idcourse;
	public $coursecode;
	public $coursename;
	public $credits;
	public $pgm_id;
	
	/**
	 *	Save the current instance of the courses to the datastore
	 *
	 *	@param	$db	PDOObject
	 *	@return	1 on success, PDOException on failure
	 **/
	public function save($db) {
		$r = $db->insert("course", array(
					"course_code" => $this->coursecode,
					"course_name" => $this->coursename,
					"credits" => $this->credits,
					"programme_id" => $this->pgm_id
				));
		
		if(is_object($r) && get_class($r) == "PDOException") return $r;
		
		$this->idcourse = $db->lastInsertId();
		return $r;
	}
	
	/**
	 *	Updates the current instance of the Course Model using the $this->idcourse value
	 *
	 *	@param	$db		PDOObject
	 *	@return	1 on success, or PDOException on failure
	 **/
	public function update($db) {		
		return $db->update("course", array(
				"course_code" => $this->coursecode,
				"course_name" => $this->coursename,
				"credits" => $this->credits,
				"programme_id" => $this->pgm_id
			), "idcourse = :cid", array(":cid" => $this->idcourse));
	}
	
	/**
	 *	Deletes an instance of the Model identified by the $cid value
	 *
	 *	@param	$cid	Course ID
	 *	@param	$db		PDOObject
	 *
	 *	@return	1 on success, or PDOException on failure
	 **/
	public static function Delete($cid, $db) {
		return $db->delete("course", "course_code = :cc", array(":cc" => $cid));
	}
	
	/**
	 *	Loads an instance of a new Course from the datastore and returns an instance of the model object.
	 *
	 *	@param	$cid	Course ID
	 *	@param	$db		PDOObject
	 *
	 *	@return Course class instance, identified by its Course ID ($cid)
	 *			FALSE	if the course is not found
	 *			PDOException in case of an error
	 **/
	public static function load($cid, $db) {
		$r = $db->select("course", "idcourse = :cid", array(":cid" => $cid));
		
		if(is_object($r) && get_class($r) == "PDOException") return $r;
		
		if(count($r) < 1) return FALSE;
		else return $r[0];
	}
	
	/**
	 *	Load and upate an instance of the Course model in the system. Values that are to be modified are passed as Arrays
	 *
	 *	@param	$post	Array of values that needs to be changed
	 *	@param	$db		PDOObject
	 *
	 *	@return	See {@link $this->update()} for return values
	 **/
	public static function LoadAndUpdate($post, $db) {
		extract($post);

		$course = Course::load($idcourse, $db);
		if(isset($credits))	$course->credits = $credits;
		if(isset($coursecode))	$course->coursecode = $coursecode;
		if(isset($coursename))	$course->coursename = $coursename;
		if(isset($pgm_id))	$course->pgm_id = $pgm_id;
		
		return $course->update($db);
	}
	
	/**
	 *	Load and Save the Course model from the array.
	 *
	 *	@param	$courseData	Array representation data of the course
	 *	@param	$db			PDOObject
	 *
	 *	@return	See {@link $this->save()} for return values
	 **/
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
		return $db->select("course", $condition, $bind);
	}	
	
}

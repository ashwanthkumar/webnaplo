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
		else {
			extract($r[0]);
			$course = new Course;
			$course->idcourse = $idcourse;
			$course->coursecode = $course_code;
			$course->coursename = $course_name;
			$course->credits = $credits;
			$course->pgm_id = $programme_id;
			
			return $course;
		}
	}
	
	/**
	 *	Load and upate an instance of the Course model in the system. Values that are to be modified are passed as Arrays
	 *
	 *	@param	$post	Array of values that needs to be changed
	 *	@param	$db		PDOObject
	 *
	 *	@return	See {@link $this->update()} for return values
	 **/
	public static function LoadAndUpdate($post, $db, &$course_object_to_return = null) {
		extract($post);

		$course = Course::load($idcourse, $db);
		if(isset($credits))	$course->credits = $credits;
		if(isset($coursecode))	$course->coursecode = $coursecode;
		if(isset($coursename))	$course->coursename = $coursename;
		if(isset($pgm_id))	$course->pgm_id = $pgm_id;
		
		$r = $course->update($db);
		
		$course_object_to_return = $course;
		
		return $r;
	}
	
	/**
	 *	Load and Save the Course model from the array.
	 *
	 *	@param	$courseData	Array representation data of the course
	 *	@param	$db			PDOObject
	 *
	 *	@return	See {@link $this->save()} for return values
	 **/
	public static function LoadAndSave($courseData, $db, &$course_object_to_return = null) {
		extract($courseData);

		$cs = $db->select("course", "course_code = :code", array(":code" => $coursecode));
		
		if(count($cs) > 0) return FALSE;
		
		$course = new Course;
		$course->credits = $credits;
		$course->coursecode = $coursecode;
		$course->coursename = $coursename;
		$course->pgm_id = $pgm_id;
		
		$r = $course->save($db);
		
		$course_object_to_return = $course;
		
		return $r;
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

	/**
	 *	Imports the Course List to the datastore. Supported file types are - 
	 *				-->	XLSX
	 *				-->	XLS
	 *				-->	CSV
	 *
	 *	@linkedTestId	TODO
	 *	
	 *	@param	$filename	Filename (with full path) to read from
	 *	@param	$pgm		Programme where the current Course list belongs
	 *	@param	$db			PDOObject
	 **/
	public static function Import($filename, $pgm, $db) {
		// Read from any of the supported files directly
		$objPHPExcel = PHPExcel_IOFactory::load($filename);

		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		// Contains the list of ids which will be generated upon inserting into the database
		$course_insert_ids = array();
		$file_column_mapping = array('A' => 'code', 'B' => 'name', 'C' => 'credits');
		$batch_errors = array();
		
		foreach($rowIterator as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(true);

			//skip first row -- Since its the heading
			if(1 === $row->getRowIndex()) {
				foreach($cellIterator as $cell) {
					if('name' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'name';
					} else if('code' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'code';
					} else if('credits' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'credits';
					}
				}
				continue;
			}

			// Getting zero-based row index
			$rowIndex = $row->getRowIndex() - 2;
			$array_data[$rowIndex] = array('name' => '', 'code' => '', 'credits' => '');
			
			// Get the data from the sheet
			foreach($cellIterator as $cell) {
				$prop = $file_column_mapping[$cell->getColumn()];
				$array_data[$rowIndex][$prop] = $cell->getValue();
			}
			
			// Insert the Staff Data into DB
			// Map the Excel File fields to Staff Model fields
			$course_post_data = array(
									'course_name' => $array_data[$rowIndex]['name'],
									'course_code' => $array_data[$rowIndex]['code'], 
									'programme_id' => $pgm, // Department value got from the form
									'credits' => $array_data[$rowIndex]['credits']
								);
			
			$r = Course::LoadAndSave($course_post_data, $db);
			
			if(!is_object($r) && $r != false) $course_insert_ids[] = $array_data[$rowIndex]['code'];
			else {
				$courseId = $array_data[$rowIndex]['code'];
				if(is_object($r))	$batch_errors[$courseId] = $r->getMessage(); 
				else $batch_errors[$courseId] = "Course already exist";
			}
		}
		// Return the batch errors if any
		return $batch_errors;
	}
}

<?php

class CIAMarks {

	public $idcia_marks;
	public $assignment;
	public $mark_1;
	public $mark_2;
	public $mark_3;		
	public $cp_id;		
	public $student_id;

	/**
	 *	Save the current instance of the CIA Marks to the datastore
	 *
	 *	@param	$db		PDOObject
	 **/	
	public function save($db) {
		$cia_marks = $db->insert("cia_marks", array(
					"assignment" => $this->assignment,
					"mark_1" => $this->mark_1,
					"mark_2" => $this->mark_2,
					"mark_3" => $this->mark_3,
					"cp_id" => $this->cp_id,
					"student_id" => $this->student_id
				));
				
		if(is_object($cia_marks) && get_class($cia_marks) == "PDOException") return $cia_marks;
		
		$this->idcia_marks = $db->lastInsertId();
		
		return $cia_marks;
	}

	/**
	 *	Updates the current instance of the CIA Marks to the datastore
	 *
	 *	@param	$db		PDOObject
	 **/	 
	public function update($db) {
		return $db->update("cia_marks", array(
					"assignment" => $this->assignment,
					"mark_1" => $this->mark_1,
					"mark_2" => $this->mark_2,
					"mark_3" => $this->mark_3,
					"cp_id" => $this->cp_id,
					"student_id" => $this->student_id
			), "idcia_marks = :cid", array(":cid" => $this->idcia_marks));
	}
	
	/**
	 *	Delete the instance of the CIA Marks. Though this is not required. 
	 *
	 *	@param	$student	Student ID
	 *	@param	$course		Course Profile ID
	 **/
	public static function Delete($student, $course, $db) {
		return $db->delete("cia_marks", "student_id = :sis and cp_id = :cpid", array(":sis" => $student, ":cpid" => $course));
	}
	
}


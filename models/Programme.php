<?php

/**
 *	Programme Model
 **/
class Programme{

	public $idprogramme;
	public $name;
	public $dept_id;
	
	public function save($db) {
		return $db->insert("programme", array(
				"name" => $this->name,
				"dept_id" => $this->dept_id
			));
	}
	
	public function update($db) {
		return $db->update("programme", array(
				"name" => $this->name,
				"dept_id" => $this->dept_id
			), "idprogramme = :pid", array(":pid" => $this->idprogramme));
	}

	public static function LoadAndUpdate($pgm, $db) {
		extract($pgm);

		$programme = new Programme;
		$programme->idprogramme = $idprogramme;
		$programme->name = $name;
		$programme->dept_id = $dept_id;
		
		return $programme->update($db);		
	}

	public static function LoadAndSave($pgm, $db) {
		extract($pgm);

		$p = $db->select("programme", "name = :name and dept_id = :did", array(":name" => $name, ":did" => $dept_id));
		if(count($p) > 0) return FALSE;
		
		$programme = new Programme;
		$programme->name = $name;
		$programme->dept_id = $dept_id;
		
		return $programme->save($db);		
	}
	
	public static function Delete($pid, $db) {
		return $db->delete("programme", "idprogramme = :pid", array(":pid" => $pid));
	}
}

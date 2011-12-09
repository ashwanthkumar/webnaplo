<?php

/**
 *	Programme Model
 **/
class Programme{

	public $idprogramme;
	public $name;
	public $dept_id;
	
	public function save($db) {
		$r= $db->insert("programme", array(
				"name" => $this->name,
				"dept_id" => $this->dept_id
			));
		if(is_object($r) && get_class($r) == "PDOException") return $r;
		
		// Get the value of AUTO_INCREMENT value from the last insert and set it as the current objects ID
		$this->idprogramme = $db->lastInsertId();
		return 1;
	}
	
	public function update($db) {
		return $db->update("programme", array(
				"name" => $this->name,
				"dept_id" => $this->dept_id
			), "idprogramme = :pid", array(":pid" => $this->idprogramme));
	}

	public static function LoadAndUpdate($pgm, $db, &$programme_object = null) {
		extract($pgm);

		$programme = new Programme;
		$programme->idprogramme = $idprogramme;
		$programme->name = $name;
		$programme->dept_id = $dept_id;
		
		$r = $programme->update($db);	
		
		$programme_object = $programme;
		
		return $r;
	}

	public static function LoadAndSave($pgm, $db, &$programme_object = null) {
		extract($pgm);

		$p = $db->select("programme", "name = :name and dept_id = :did", array(":name" => $name, ":did" => $dept_id));
		if(count($p) > 0) return FALSE;
		
		$programme = new Programme;
		$programme->name = $name;
		$programme->dept_id = $dept_id;
		
		$r = $programme->save($db);		
		
		$programme_object = $programme;
		
		return $r;
	}
	
	public static function Delete($pid, $db) {
		return $db->delete("programme", "idprogramme = :pid", array(":pid" => $pid));
	}
}


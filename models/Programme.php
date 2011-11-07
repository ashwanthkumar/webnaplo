<?php

class Programme{

	public $idprogramme;
	public $name;
	public $dept_iddept;
	
	public function save($db) {
		return $db->insert("programme", array(
				"name" => $this->name,
				"dept_iddept" => $this->dept_iddept
			));
	}
	
	public function update($db) {
		return $db->update("programme", array(
				"name" => $this->name,
				"dept_iddept" => $this->dept_iddept
			), "idprogramme = :pid", array(":pid" => $this->idprogramme));
	}

	public static function LoadAndUpdate($pgm, $db) {
		extract($pgm);

		$programme = new Programme;
		$programme->idprogramme = $idprogramme;
		$programme->name = $name;
		$programme->dept_iddept = $dept_iddept;
		
		return $programme->update($db);		
	}
	
	public static function Delete($pid, $db) {
		return $db->delete("programme", "idprogramme = :pid", array(":pid" => $pid));
	}
}

<?php

class Department {

	public $iddept;
	public $name;
	
	public function save($db) {
		return $db->insert("dept", array("name" => $this->name));
	}
	
	public function update($db) {
		return $db->update("dept", array("name" => $this->name), "iddept = :did", array(":did" => $this->iddept));
	}
	
	public static function LoadAndUpdate($dept, $db) {
		extract($department);

		$department = new Department;
		$department->name = $name;
		
		return $department->update($db);		
	}
	
	public static function LoadAndSave($department, $db) {
		extract($department);
		
		$d = new Department;
		if(isset($name)) $d->name = $name;
		
		return $d->save($db);
	}

	public static function Delete($dip, $db) {
		return $db->delete("dept", "iddept = :dip", array(":dip" => $dip));
	}
}


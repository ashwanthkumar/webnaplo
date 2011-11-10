<?php

class Section {

	public $idclass;
	public $name;
	public $programme_id;

	public function save($db) {
		return $db->insert("class", array(
			"name" => $this->name,
			"programme_id" => $this->programme_id
		));
	}
	
	public function update($db) {
		return $db->update("class", array(
			"name" => $this->name,
			"programme_id" => $this->programme_id
		), "idclass = :cid", array(":cid" => $this->idclass));
	}
	
	public static function Delete($cid, $db) {
		return $db->delete("class", "idclass = :cid", array(":cid" => $cid));
	}

	public static function LoadAndUpdate($sec, $db) {
		extract($sec);

		$section = new Section;
		$section->idclass = $idclass;
		$section->name = $name;
		$section->programme_id = $programme_id;
		
		return $section->update($db);
	}

	public static function LoadAndSave($sec, $db) {
		extract($sec);

		$cls = $db->select("class", "name = :name and programme_id = :pid", array(":name" => $name, ":pid" => $programme_id));
		
		if(count($cls) > 0) return false;
		
		$section = new Section;
		$section->name = $name;
		$section->programme_id = $programme_id;
		
		return $section->save($db);
	}
}

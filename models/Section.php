<?php

/**
 *	Section or most commonly called as "Class" in the system for storing the logical classes in the university. 
 *
 *	@author	Ashwanth Kumar <ashwanth@ashwanthkumar.in>
 *	@date 04/12/2011
 **/
class Section {

	public $idclass;
	public $name;
	public $programme_id;

	/**
	 *	Saves the current instance of the Section object to the datastore
	 *
	 *	@param	$db	PDOObject
	 *
	 *	@return	1 on success or PDOException on error
	 **/
	public function save($db) {
		$r = $db->insert("class", array(
			"name" => $this->name,
			"programme_id" => $this->programme_id
		));
		
		if(is_object($r) && get_class($r) == "PDOException") return $r;
		
		$this->idclass = $db->lastInsertId();
		return $r;
	}
	
	/**
	 *	Updates the current instance of the object in the datastore
	 *
	 *	@param	$db	PDOObject
	 *
	 *	@return	1 on success, or PDOException on error
	 **/
	public function update($db) {
		return $db->update("class", array(
			"name" => $this->name,
			"programme_id" => $this->programme_id
		), "idclass = :cid", array(":cid" => $this->idclass));
	}
	
	/**
	 *	Delete the Section Model entity in the datastore
	 *
	 *	@param	$cid	Class ID
	 *	@param	$db		PDOObject
	 *
	 *	@return 1 on success, PDOException on error
	 **/
	public static function Delete($cid, $db) {
		return $db->delete("class", "idclass = :cid", array(":cid" => $cid));
	}
	
	/**
	 *	Loads an instance of Class / Section from the datastore based on the idclass 
	 *
	 *	@param	$cid	Class ID
	 *	@param	$db		PDOObject
	 *
	 *	@return Section Instance based on the $cid value
	 *			FALSE if class / section not found
	 **/
	public static function load($cid, $db) {
		$r = $db->select("class", "idclass = :cid", array(":cid" => $cid));
		
		if(count($r) < 1) return FALSE;
		
		extract($r[0]);
		
		$class = new Section;
		$class->idclass = $idclass;
		$class->name = $name;
		$class->programme_id = $programme_id;
		
		return $class;
	}

	/**
	 *	Loads an instance of Section model and updates it
	 *
	 *	@param	$sec	New values that needs to be updated
	 *	@param	$db		PDOObject
	 *
	 *	@return	same as {@link Section::update()}
	 **/
	public static function LoadAndUpdate($sec, $db) {
		extract($sec);

		$section = Section::load($idclass, $db);
		if(isset($name)) $section->name = $name;
		if(isset($programme_id)) $section->programme_id = $programme_id;
		
		return $section->update($db);
	}

	/**
	 *	Loads an instance of Section from the parameters and saves it
	 *
	 *	@param	$sec	Array of elements to load from
	 *	@param	$db		PDOObject
	 *
	 *	@return	1 on success, false if the name and programme pair of section already exist, or PDOException on error
	 **/
	public static function LoadAndSave($sec, $db) {
		extract($sec);

		$cls = $db->select("class", "name = :name and programme_id = :pid", array(":name" => $name, ":pid" => $programme_id));
		
		if(count($cls) > 0) return false;
		
		$section = new Section;
		$section->name = $name;
		$section->programme_id = $programme_id;
		
		return $section->save($db);
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
		return $db->select("class", $condition, $bind);
	}
}

<?php

class LockUnLock {
	
	public $idlock_unlock;	
	public $assignment;	
	public $attendance;		
	public $cia_1;
	public $cia_2;
	public $cia_3;
	public $class_id;
	
	/**
	 * Save the entity of the lock and unlock status of the present entity
	 **/
	public function save($db) {
		return $db->insert("lock_unlock", array(
			"assignment" => $this->assignment,
			"attendance" => $this->attendance,
			"cia_1" => $this->cia_1,
			"cia_2" => $this->cia_2,
			"cia_3" => $this->cia_3,
			"class_id" => $this->class_id
		));
	}

	/**
	 * Update the entity of the lock and unlock status 
	 **/
	public function update($db) {
		return $db->update("lock_unlock", array(
			"assignment" => $this->assignment,
			"attendance" => $this->attendance,
			"cia_1" => $this->cia_1,
			"cia_2" => $this->cia_2,
			"cia_3" => $this->cia_3,
			"class_id" => $this->class_id
		), "idlock_unlock = :lid", array(":lid" => $this->idlock_unlock));
	}
	
	/**
	 * Delete the entity of the given class 
	 **/
	public static function Delete($cid, $db) {
		return $db->delete("lock_unlock", "class_id = :cid", array(":cid" => $cid));
	}

	/**
	 * Load and Update a lock and unlock status, when POSTING something 
	 **/
	public static function LoadAndUpdate($loc, $db) {
		extract($loc);

		$lock = new LockUnLock;
		$lock->idlock_unlock = $idlock_unlock;
		$lock->assignment = $assignment;
		$lock->attendance = $attendance;
		$lock->cia_1 = $cia_1;
		$lock->cia_2 = $cia_2;
		$lock->cia_3 = $cia_3;
		$lock->class_id = $class_id;
		
		return $lock->update($db);
	}
	
	/**
	 * Get the lock and unlock status for all classes, used generally for displaying in the view layer
	 **/
	public static function getLockUnlockStatus($db) {
		return $db->select("lock_unlock");
	}
	
	/**
	 * Get the block status for a given class
	 **/
	public static function getBlockStatus($classid, $db) {
		return $db->select("lock_unlock", "class_id = :classid", array(":classid" => $classid));
	}
	
	/**
	 * Lock the object for a given class
	 **/
	public static function lock($obj, $classid, $db) {
		switch($obj) {
			case 1:
				return $db->update("lock_unlock", array("cia_1" => 1), "class_id = :classid", array(":classid" => $classid));
			case 2:
				return $db->update("lock_unlock", array("cia_2" => 1), "class_id = :classid", array(":classid" => $classid));
			case 3:
				return $db->update("lock_unlock", array("cia_3" => 1), "class_id = :classid", array(":classid" => $classid));
			case 4:
				return $db->update("lock_unlock", array("assignment" => 1), "class_id = :classid", array(":classid" => $classid));
			case 5:
				return $db->update("lock_unlock", array("attendance" => 1), "class_id = :classid", array(":classid" => $classid));
		}
	}	

	/**
	 * Unlock the object for a given class
	 **/
	public static function unlock($obj, $classid, $db) {
		switch($obj) {
			case 1:
				return $db->update("lock_unlock", array("cia_1" => 0), "class_id = :classid", array(":classid" => $classid));
			case 2:
				return $db->update("lock_unlock", array("cia_2" => 0), "class_id = :classid", array(":classid" => $classid));
			case 3:
				return $db->update("lock_unlock", array("cia_3" => 0), "class_id = :classid", array(":classid" => $classid));
			case 4:
				return $db->update("lock_unlock", array("assignment" => 0), "class_id = :classid", array(":classid" => $classid));
			case 5:
				return $db->update("lock_unlock", array("attendance" => 0), "class_id = :classid", array(":classid" => $classid));
		}
	}
	
	/**
	 * Initialize the Lock and Unlock status for all the classes
	 *
	 *	LockUnLock::initLockUnLock()
	 **/
	public static function initLockUnLock($db) {
		$db->run("delete from lock_unlock where 1 = 1");
		
		$classes = $db->select("class");
		
		// Iterate over each class and init all their lock status
		foreach($classes as $class) {
			$l = new LockUnLock;
			$l->assignment = 0;	
			$l->attendance = 0;		
			$l->cia_1 = 0;
			$l->cia_2 = 0;
			$l->cia_3 = 0;
			$l->class_id = $class['idclass'];

			$l->save($db);
		}
	}
}

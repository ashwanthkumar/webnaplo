<?php

class LockUnLock {
	
	public $idlock_unlock;	
	public $assignment;	
	public $attendance;		
	public $cia_1;
	public $cia_2;
	public $cia_3;
	public $class_idclass;
	
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
	
	public static function Delete($cid, $db) {
		return $db->delete("lock_unlock", "class_id = :cid", array(":cid" => $cid));
	}

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
	
		
	public static function getLockUnlockStatus($db) {
		return $db->select("lock_unlock");
	}
	
	public static function getBlockStatus($classid, $db) {
		return $db->select("lock_unlock", "class_id = :classid", array(":classid" => $classid));
	}
	
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
}

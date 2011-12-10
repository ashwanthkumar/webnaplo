<?php

class LockUnLock {
	
	public $idlock_unlock;	
	public $assignment;	
	public $attendance;		
	public $cia_1;
	public $cia_2;
	public $cia_3;
	public $cp_id;
	
	/**
	 * Save the entity of the lock and unlock status of the present entity
	 **/
	public function save($db) {
		$r = $db->insert("lock_unlock", array(
			"assignment" => $this->assignment,
			"attendance" => $this->attendance,
			"cia_1" => $this->cia_1,
			"cia_2" => $this->cia_2,
			"cia_3" => $this->cia_3,
			"cp_id" => $this->cp_id
		));
		
		if(is_object($r) && get_class($r) == "PDOException") return $r;
		
		// Get the value of AUTO_INCREMENT value from the last insert and set it as the current objects ID
		$this->idlock_unlock = $db->lastInsertId();
		return 1;
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
			"cp_id" => $this->cp_id
		), "idlock_unlock = :lid", array(":lid" => $this->idlock_unlock));
	}
	
	/**
	 * Delete the entity of the given class 
	 **/
	public static function Delete($cid, $db) {
		return $db->delete("lock_unlock", "cp_id = :cid", array(":cid" => $cid));
	}

	/**
	 * Load and Update a lock and unlock status, when POSTING something 
	 **/
	public static function LoadAndUpdate($loc, $db, &$lock_unlock_object = null) {
		extract($loc);

		$lock = new LockUnLock;
		$lock->idlock_unlock = $idlock_unlock;
		$lock->assignment = $assignment;
		$lock->attendance = $attendance;
		$lock->cia_1 = $cia_1;
		$lock->cia_2 = $cia_2;
		$lock->cia_3 = $cia_3;
		$lock->cp_id = $cp_id;
		
		$r = $lock->update($db);
		
		$lock_unlock_object = $lock;
		
		return $r;
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
		return $db->select("lock_unlock", "cp_id = :classid", array(":classid" => $classid));
	}
	
	/**
	 * Lock the object for a given class
	 **/
	public static function lock($obj, $classid, $db) {
		switch($obj) {
			case 1:
				return $db->update("lock_unlock", array("cia_1" => 1), "cp_id = :classid", array(":classid" => $classid));
			case 2:
				return $db->update("lock_unlock", array("cia_2" => 1), "cp_id = :classid", array(":classid" => $classid));
			case 3:
				return $db->update("lock_unlock", array("cia_3" => 1), "cp_id = :classid", array(":classid" => $classid));
			case 4:
				return $db->update("lock_unlock", array("assignment" => 1), "cp_id = :classid", array(":classid" => $classid));
			case 5:
				return $db->update("lock_unlock", array("attendance" => 1), "cp_id = :classid", array(":classid" => $classid));
		}
	}	

	/**
	 * Unlock the object for a given class
	 **/
	public static function unlock($obj, $classid, $db) {
		switch($obj) {
			case 1:
				return $db->update("lock_unlock", array("cia_1" => 0), "cp_id = :classid", array(":classid" => $classid));
			case 2:
				return $db->update("lock_unlock", array("cia_2" => 0), "cp_id = :classid", array(":classid" => $classid));
			case 3:
				return $db->update("lock_unlock", array("cia_3" => 0), "cp_id = :classid", array(":classid" => $classid));
			case 4:
				return $db->update("lock_unlock", array("assignment" => 0), "cp_id = :classid", array(":classid" => $classid));
			case 5:
				return $db->update("lock_unlock", array("attendance" => 0), "cp_id = :classid", array(":classid" => $classid));
		}
	}
	
	/**
	 * Initialize the Lock and Unlock status for all the course profiles
	 *
	 *	LockUnLock::initLockUnLock()
	 **/
	public static function initLockUnLock($db, $totalReset = false) {
		if($totalReset) {
			// Delete any existing locks
			$db->run("delete from lock_unlock where 1 = 1");
		}
		
		$course_profiles = CourseProfile::search($db);
		
		// Iterate over each class and init all their lock status
		foreach($course_profiles as $cp) {
			$l = new LockUnLock;
			$l->assignment = 0;	
			$l->attendance = 0;		
			$l->cia_1 = 0;
			$l->cia_2 = 0;
			$l->cia_3 = 0;
			$l->cp_id = $cp['idcourse_profile'];

			$l->save($db);
		}
	}
	
	/**
	 *	Get the list of course profile with their lock and unlock status
	 *
	 *	@param	$db		PDOObject
	 *	@return	Array of Course profiles with their lock and unlock statuc
	 **/
	public static function getList($db) {
		return $db->run("select cp.idcourse_profile as id, lu.assignment as assignment, lu.attendance as attendance, lu.cia_1 as c1, lu.cia_2 as c2, lu.cia_3 as c3, cp.name as name from lock_unlock lu, course_profile cp where cp.idcourse_profile = lu.cp_id");
	}
	
	/**
	 *	Add a course profile to the current lock and unlock status
	 *
	 *	@param	$cpid	Course Profile ID
	 *	@param	$db		PDOObject
	 *
	 *	@return Same as {@link LockUnlock::save()}
	 **/
	public static function addCourseProfile($cpid, $db, &$lock_unlock_object = null) {
			$l = new LockUnLock;
			$l->assignment = 0;	
			$l->attendance = 0;		
			$l->cia_1 = 0;
			$l->cia_2 = 0;
			$l->cia_3 = 0;
			$l->cp_id = $cpid;

			$r = $l->save($db);
			
			$lock_unlock_object = $l;
			
			return $l;
	}
}


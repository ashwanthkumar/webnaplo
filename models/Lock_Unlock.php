<?php

class LockUnLock {
	
	private $idlock_unlock;
		public function getIdlock_unlock() 
		{ 
		return $this->idlock_unlock;
		}
		public function setIdlock_unlock($idlock_unlock)
		{
			$this->idlock_unlock = $idlock_unlock;
		}
	
	private $assignment;
		public function getAssignment() 
		{ 
		return $this->assignment;
		}
		public function setAssignment($attendance)
		{
			$this->assignment = $assignment;
		}
	
	private $attendance;
		public function getAttendance() 
		{ 
		return $this->attendance;
		}
		public function setAttendance($attendance)
		{
			$this->attendance = $attendance;
		} 
		
	private $cia_1;
		public function getCia_1() 
		{ 
		return $this->cia_1;
		}
		public function setCia_1($cia_1)
		{
			$this->cia_1 = $cia_1;
		}
		
	private $cia_2;
		public function getCia_2() 
		{ 
		return $this->cia_2;
		}
		public function setCia_2($cia_2)
		{
			$this->cia_2 = $cia_2;
		}
		
	private $cia_3;
		public function getCia_3() 
		{ 
		return $this->cia_3;
		}
		public function setCia_3($cia_3)
		{
			$this->cia_3 = $cia_3;
		}
	private $class_idclass;
		public function getClass_idclass() 
		{ 
		return $this->Class_idclass;
		}
		public function setClass_idclass($Class_idclass)
		{
			$this->idclass = $Class_idclass;
		}
		
	public static function getLockUnlockStatus() {
			// Return lock/unlock status 
		}
		
	public static function getBlockStatus() {
			// Return lock/unlock status 
		}
		
	public static function unblockUser() {
			// Return lock/unlock status 
		}
	
	
	}

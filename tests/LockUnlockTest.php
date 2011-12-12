<?php

// Main WebNaplo Test Class file
require_once("WebNaploTest.php");

// Including the Model files
require_once("../models/LockUnlock.php");

/**
 *	Test cases for unit testing the LockUnlock Model
 *
 *	@author Team Webnaplo
 *	@date 06/12/2011
 **/
class LockUnlockTest extends WebNaploTest {

	public $db;
	
	public function __construct() {
		$this->db = $this->initDB();
	}
	public function testSave()
	{
	$lockunlock = new LockUnlock;
		
		
		$lockunlock->assignment = 1;
		$lockunlock->attendance = 1;
		$lockunlock->cia_1 = 1;
		$lockunlock->cia_2=1;
		$lockunlock->cia_3=1;
		$lockunlock->cp_id=33;
		
		$r = $lockunlock->save($this->db);
		
		// Testing that the transaction was not a failure
		$this->assertEquals(false, is_object($r));
		$this->assertNotInstanceOf('PDOException', $r);
		// Verifing its a positively only one
		$this->assertEquals(1, $r);
		
		// Now to delete the entity
		$this->assertEquals(1, LockUnlock::Delete($lockunlock->cp_id, $this->db));

	}
	public function testUpdate()
	{
	}
	
	public function testDelete()
	{
	}
	
	public function testLoadAndUpdate()
	{
		$lockunlock_post = array("assignment" => 1, "attendance" => 1, "cia_1" => 1, "cia_2" => 1, "cia_3" => 1, "cp_id" =>33);
	
		$result = LockUnlock::LoadAndUpdate($lockunlock_post, $this->db, $course);
		
		// Test creation
		$this->assertEquals($result, 1);

		$lockunlock_post = array("assignment" => 0, "attendance" => 1, "cia_1" => 1, "cia_2" => 1, "cia_3" => 1, "cp_id" =>33, "idlock_unlock" => $course-> idlock_unlock);
		$result = LockUnlock::LoadAndUpdate($lockunlock_post, $this->db, $course);
		// Test updation
		$this->assertEquals($result, 1);
		
		// Now Delete it
		$result = LockUnlock::Delete($course->cp_id, $this->db);
		// Test delting
		$this->assertEquals($result, 1);
	}
	public function testGetLockUnlockStatus()
	{
	}
	public function testBlockStatus()
	{
	}
	public function testLock()
	{
	}
	public function testUnlock()
	{
	}
	public function testInitLockUnlock()
	{
	}
	public function testGetList()
	{
	}
	public function testAddLockUnlock()
	{
	}
}
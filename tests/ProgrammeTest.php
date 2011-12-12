<?php

// Main WebNaplo Test Class file
require_once("WebNaploTest.php");

// Including the Model files
require_once("../models/Programme.php");

/**
 *	Test cases for unit testing the Programme Model
 *
 *	@author Team Webnaplo
 *	@date 06/12/2011
 **/
class ProgrammeTest extends WebNaploTest {

	public $db;
	
	public function __construct() {
		$this->db = $this->initDB();
	}
	public function testSave()
	{
	$programme = new Programme;
		
		
		$programme->name = "B.Tech ECE";
		$programme->dept_id = 1;
		$r = $programme->save($this->db);
		
		// Testing that the transaction was not a failure
		$this->assertEquals(false, is_object($r));
		$this->assertNotInstanceOf('PDOException', $r);
		// Verifing its a positively only one
		$this->assertEquals(1, $r);
		
		// Now to delete the entity
		$this->assertEquals(1, Programme::Delete($programme->idprogramme, $this->db));

	}
	public function testUpdate()
	{
	}
	
	public function testDelete()
	{
	}
	
	public function testLoadAndSave()
	{
	$programme_post = array("name" => "Test Programme", "dept_id" => 3);
		
		$result = Programme::LoadAndSave($programme_post, $this->db, $course);
		// Test if the creation was successful
		$this->assertEquals($result, 1);
		
		// Now delete the created programme and test it
		$result = Programme::Delete($course->idprogramme, $this->db);
		$this->assertEquals($result, 1);
	}
	public function testLoadAndUpdate()
	{
	$programme_post = array("name" => "Test programme", "dept_id" => 3);
		$result = Programme::LoadAndSave($programme_post, $this->db, $course);
		
		// Test creation
		$this->assertEquals($result, 1);

		$programme_post = array("name" => "Test programme Update", "dept_id" => 3, "idprogramme" => $course->idprogramme);
		$result = Programme::LoadAndUpdate($programme_post, $this->db, $course);
		// Test updation
		$this->assertEquals($result, 1);
		
		// Now Delete it
		$result = Programme::Delete($course->idprogramme, $this->db);
		// Test delting
		$this->assertEquals($result, 1);
	}
	
	
	
}
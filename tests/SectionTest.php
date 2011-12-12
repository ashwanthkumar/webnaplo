<?php

// Main WebNaplo Test Class file
require_once("WebNaploTest.php");

// Including the Model files
require_once("../models/Section.php");

/**
 *	Test cases for unit testing the Section Model
 *
 *	@author Team Webnaplo
 *	@date 06/12/2011
 **/
class SectionTest extends WebNaploTest {

	public $db;
	
	public function __construct() {
		$this->db = $this->initDB();
	}
	public function testSave()
	{
	$section = new Section;
		
		
		$section->name = "BTECH IT";
		$section->programme_id = 1;
		$r = $section->save($this->db);
		
		// Testing that the transaction was not a failure
		$this->assertEquals(false, is_object($r));
		$this->assertNotInstanceOf('PDOException', $r);
		// Verifing its a positively only one
		$this->assertEquals(1, $r);
		
		// Now to delete the entity
		$this->assertEquals(1, Section::Delete($section->idclass, $this->db));

	}
	public function testUpdate()
	{
	}
	
	public function testDelete()
	{
	}
	
	public function testLoad()
	{
	}
	
	public function testLoadAndSave()
	{
	$section_post = array("name" => "Test section", "programme_id" => 3);
		
		$result = Section::LoadAndSave($section_post, $this->db, $course);
		// Test if the creation was successful
		$this->assertEquals($result, 1);
		
		// Now delete the created section and test it
		$result = Section::Delete($course->idclass, $this->db);
		$this->assertEquals($result, 1);
	}
	
	public function testLoadAndUpdate()
	{
	$section_post = array("name" => "Test section", "programme_id" => 3);
		$result = Section::LoadAndSave($section_post, $this->db, $course);
		
		// Test creation
		$this->assertEquals($result, 1);

		$section = array("name" => "Test section Update", "programme_id" => 3, "idclass" => $course->idclass);
		$result = Section::LoadAndUpdate($section_post, $this->db, $course);
		// Test updation
		$this->assertEquals($result, 1);
		
		// Now Delete it
		$result = Section::Delete($course->idclass, $this->db);
		// Test delting
		$this->assertEquals($result, 1);
	
	}
	
	
	
	public function testSearch()
	{
	$sectionList = $this->db->select("class");
		$sectionSearchList = Section::search($this->db);
		
		$this->assertEquals(count($sectionList), count($sectionSearchList));
	}
	
}
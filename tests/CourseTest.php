<?php

// Main WebNaplo Test Class file
require_once("WebNaploTest.php");

// Including the Model files
require_once("../models/Course.php");

/**
 *	Test cases for unit testing the Course Model
 *
 *	@author Team Webnaplo
 *	@date 06/12/2011
 **/
class CourseTest extends WebNaploTest {

	public $db;
	
	public function __construct() {
		$this->db = $this->initDB();
	}
	public function testSave()
	{
		$course = new Course;
		
		$course->coursecode = "BITCIT701R01";
		$course->coursename = "CBD";
		$course->credits = 5;
		$course->pgm_id = 3;
	
		$r = $course->save($this->db);
		
		// Testing that the transaction was not a failure
		$this->assertEquals(false, is_object($r));
		$this->assertNotInstanceOf('PDOException', $r);
		// Verifing its a positively only one
		$this->assertEquals(1, $r);
		
		// Now to delete the entity
		$this->assertEquals(1, Course::Delete($course->coursecode, $this->db));
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
	$course_post = array("coursename" => "GC", "coursecode" => "BITCIT704R01", "credits" => 4,"pgm_id" => 1);
		
		$result = Course::LoadAndSave($course_post, $this->db, $course1);
		// Test if the creation was successful
		$this->assertEquals($result, 1);
		
		// Now delete the created course profile and test it
		$result = Course::Delete($course1->coursecode, $this->db);
		$this->assertEquals($result, 1);
	}
	
	public function testLoadAndUpdate()
	{
	$course_post = array("coursename" => "GC", "coursecode" => "BITCIT704R01", "credits" => 4, "pgm_id" => 1);
	
		$result = Course::LoadAndSave($course_post, $this->db, $course1);
		
		// Test creation
		$this->assertEquals($result, 1);

		$course_post = array("coursename" => "GCC", "coursecode" => "BITCIT704R01", "credits" => 4, "pgm_id" => 1, "idcourse" => $course1->idcourse);
		$result = Course::LoadAndUpdate($course_post, $this->db, $course1);
		// Test updation
		$this->assertEquals($result, 1);
		
		// Now Delete it
		$result = Course::Delete($course1->coursecode, $this->db);
		// Test delting
		$this->assertEquals($result, 1);
	}
	
	
	
	public function testSearch()
	{
	$courseList = $this->db->select("course");
		$courseSearchList = Course::search($this->db);
		
		$this->assertEquals(count($courseList), count($courseSearchList));
	}
	
}
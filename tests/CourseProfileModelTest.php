<?php

// Main WebNaplo Test Class file
require_once("WebNaploTest.php");

// Including the Model files
require_once("../models/CourseProfile.php");
require_once("../models/Staff.php");
require_once("../models/LockUnlock.php");

/**
 *	Test cases for unit testing the CourseProfile Model
 *
 *	@author Team Webnaplo
 *	@date 20/11/2011
 */
 class CourseProfileModelTest extends WebNaploTest {

	public $db;
	private $lastInsertId;
	
	public function __construct() {
		$this->db = $this->initDB();
	}
	
	/**
	 *	Testing creating and deleting of a course profile
	 **/
	public function testSave() {
		$course_profile = new CourseProfile;
		$course_profile->name = "Test Course Profile";
		$course_profile->course_id = 1;
		$course_profile->staff_id = 1;
		
		$result = $course_profile->save($this->db);
		
		// Test if the insert was successful
		$this->assertEquals($result, 1);
		
		// Now remove the created object
		$result = CourseProfile::Delete($course_profile->idcourse_profile, $this->db);
		
		// Test if the delete was successful
		$this->assertEquals($result, 1);
	}
	
	/**
	 *	Testing the LoadAndSave Operation of Course Profile
	 **/
	public function testLoadAndSave() {
		$course_profile_post = array("name" => "Test Course Profile", "course_id" => 1, "staff_id" => 1);
		
		$result = CourseProfile::LoadAndSave($course_profile_post, $this->db, $course);
		// Test if the creation was successful
		$this->assertEquals($result, 1);
		
		// Now delete the created course profile and test it
		$result = CourseProfile::Delete($course->idcourse_profile, $this->db);
		$this->assertEquals($result, 1);
	}
	
	/**
	 *	Testing the LoadAndUpdate operation of Course Profile
	 **/
	public function testLoadAndUpdate() {
		$course_profile_post = array("name" => "Test Course Profile", "course_id" => 1, "staff_id" => 1);
		$result = CourseProfile::LoadAndSave($course_profile_post, $this->db, $course);
		
		// Test creation
		$this->assertEquals($result, 1);

		$course_profile_post = array("name" => "Test Course Profile Update", "course_id" => 1, "staff_id" => 1, "idcourse_profile" => $course->idcourse_profile);
		$result = CourseProfile::LoadAndUpdate($course_profile_post, $this->db, $course);
		// Test updation
		$this->assertEquals($result, 1);
		
		// Now Delete it
		$result = CourseProfile::Delete($course->idcourse_profile, $this->db);
		// Test delting
		$this->assertEquals($result, 1);
	}
	
	/**
	 *	Testing the deletion of course profiles for a given staff member
	 **/
	public function testDeleteByStaff() {
		// We need to create a staff member, add its properties and create a set of course profiles for them and prove the test
		$this->markTestIncomplete("We need to create a staff member, add its properties and create a set of course profiles for them and prove the test");
	}
	
	/**
	 *	Testing add students to the Course Profile
	 *
	 *	@test
	 **/
	public function testAddStudent() {
		$course_profile_post = array("name" => "Test Course Profile", "course_id" => 1, "staff_id" => 1);
		
		$result = CourseProfile::LoadAndSave($course_profile_post, $this->db, $course);
		// Test if the creation was successful
		$this->assertEquals($result, 1);

		// Array of student register numbers out of which one is fake
		$students = array(21203015, 21203009, 12345);
		
		$cp = CourseProfile::load($course->idcourse_profile, $this->db);
		$numberOfStudentsInserted = $cp->addStudent($students, $this->db);
		
		$this->assertNotEquals(count($students), $numberOfStudentsInserted, "Number of Students and inserted value should not match");
		
		// Remove the course profile
		$result = CourseProfile::Delete($course->idcourse_profile, $this->db);
		// Test delting
		$this->assertEquals($result, 1);
	}
	public function testUpdate()
	{
	}
	
	public function testLoad()
	{
	}
	public function testSearch()
	{
	$courseProfileList = $this->db->select("course_profile");
		$courseProfileSearchList = CourseProfile::search($this->db);
		
		$this->assertEquals(count($courseProfileList), count($courseProfileSearchList));
	}
}
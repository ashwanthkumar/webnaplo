<?php

// Main WebNaplo Test Class file
require_once("WebNaploTest.php");

// Including the Model files
require_once("../models/CourseProfile.php");
require_once("../models/Staff.php");

/**
 *	Test cases for unit testing the CourseProfile Model
 *
 *	@author Team Webnaplo
 *	@date 20/11/2011
 * 	@outputBuffering enabled
 */
 class CourseProfileTest extends WebNaploTest {

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
		$this->lastInsertId = $this->db->lastInsertId();
		
		// Test if the insert was successful
		$this->assertEquals($result, 1);
		
		// Now remove the created object
		$result = CourseProfile::Delete($this->lastInsertId, $this->db);
		
		// Test if the delete was successful
		$this->assertEquals($result, 1);
	}
	
	/**
	 *	Testing the LoadAndSave Operation of Course Profile
	 **/
	public function testLoadAndSave() {
		$course_profile_post = array("name" => "Test Course Profile", "course_id" => 1, "staff_id" => 1);
		
		$result = CourseProfile::LoadAndSave($course_profile_post, $this->db);
		$this->lastInsertId = $this->db->lastInsertId();
		// Test if the creation was successful
		$this->assertEquals($result, 1);
		
		// Now delete the created course profile and test it
		$result = CourseProfile::Delete($this->lastInsertId, $this->db);
		$this->assertEquals($result, 1);
	}
	
	/**
	 *	Testing the LoadAndUpdate operation of Course Profile
	 **/
	public function testLoadAndUpdate() {
		$course_profile_post = array("name" => "Test Course Profile", "course_id" => 1, "staff_id" => 1);
		$result = CourseProfile::LoadAndSave($course_profile_post, $this->db);
		$this->lastInsertId = $this->db->lastInsertId();
		// Test creation
		$this->assertEquals($result, 1);

		$course_profile_post = array("name" => "Test Course Profile Update", "course_id" => 2, "staff_id" => 1, "idcourse_profile" => $this->lastInsertId);
		$result = CourseProfile::LoadAndUpdate($course_profile_post, $this->db);
		// Test updation
		$this->assertEquals($result, 1);
		
		// Now Delete it
		$result = CourseProfile::Delete($this->lastInsertId, $this->db);
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
}
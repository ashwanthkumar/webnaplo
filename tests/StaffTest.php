<?php

// Main WebNaplo Test Class file
require_once("WebNaploTest.php");

// Including the Model files
require_once("../models/Staff.php");

/**
 *	Test cases for unit testing the staff Model
 *
 *	@author Team Webnaplo
 *	@date 06/12/2011
 **/
class StaffTest extends WebNaploTest {

	public $db;
	
	public function __construct() {
		$this->db = $this->initDB();
	}
	public function testSave()
	{
		$staff = new Staff;
		
		$staff->designation = "asst prof";
		$staff->address = "Sample Address being added for testing";
		$staff->email = "staff.email@src.sastra.edu";
		$staff->is_blocked = 0;
		$staff->mobile = '1234567890';
		$staff->name = 'Some staff Name';
		$staff->password = 'src';
		$staff->staff_id = "C123";
		$staff->dept_id = 5;
		
		$r = $staff->save($this->db);
		
		// Testing that the transaction was not a failure
		$this->assertEquals(false, is_object($r));
		$this->assertNotInstanceOf('PDOException', $r);
		// Verifing its a positively only one
		$this->assertEquals(1, $r);
		
		// Now to delete the entity
		$this->assertEquals(1, Staff::Delete($staff->staff_id, $this->db));

	}
		
	public function testDelete()
	{
	}
	
	public function testLoad()
	{
	}
	
	public function testLoadAndSave()
	{
	$staff_post = array("name" => "Test staff", "designation" => "some desg", "dept_id" => 5,"staff_id" => "C1234", "email" =>"as@gmail.com", "mobile" => "1234567891", "address" => "some", "is_blocked" => 0, "password" => "src");
		
		$result = Staff::LoadAndSave($staff_post, $this->db, $course);
		// Test if the creation was successful
		$this->assertEquals($result, 1);
		
		// Now delete the created section and test it
		$result = Staff::Delete($course->staff_id, $this->db);
		$this->assertEquals($result, 1);
	}
	
	public function testSearch()
	{
	$staffList = $this->db->select("staff");
		$staffSearchList = Staff::search($this->db);
		
		$this->assertEquals(count($staffList), count($staffSearchList));
	}
	
	public function testSGetCourseProfiles()
	{
	}
	public function testGetCourseProfiles()
	{
	}
	public function testSClearTimetable()
	{
	}
	public function testClearTimetable()
	{
	}
	public function testSGetTimetable()
	{
	}
	public function testGetTimetable()
	{
	}
	public function testGetCourseProfile()
	{
	}
	public function testSGetPendingAttendance()
	{
	}
	public function testGetPendingAttendance()
	{
	}
	public function testGetstaffListForCourseProfile()
	{
	}
	public function testGetPendingCIA()
	{
	}
	public function testGetLackStatusForCourseProfile()
	{
	}
	public function testGetLackStatus()
	{
	}
	public function testGetBlockStatus()
	{
	}
}
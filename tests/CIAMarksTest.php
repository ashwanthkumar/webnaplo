<?php

// Main WebNaplo Test Class file
require_once("WebNaploTest.php");

// Including the Model files
require_once("../models/CIAMarks.php");
require_once("../models/Student.php");
require_once("../models/CourseProfile.php");
/**
 *	Test cases for unit testing the CIAMarks Model
 *
 *	@author Team Webnaplo
 *	@date 06/12/2011
 **/
class CIAMarksTest extends WebNaploTest {

	public $db;
	
	public function __construct() {
		$this->db = $this->initDB();
	}
	public function testSave()
	{
	$ciamarks = new CIAMarks;
		
		
		$ciamarks->assignment = 1;
		$ciamarks->mark_1 = 1;
		$ciamarks->mark_2=1;
		$ciamarks->mark_3=1;
		$ciamarks->course_profile_idcourse_profile=1;
		$ciamarks->student_idstudent=1;
		
		$this->assertEquals(1, $ciamarks->save($this->db));
		
		// Now to remove the added ciamarks
		$this->assertEquals(1, ciamarks::Delete($ciamarks->student_idStudent,$ciamarks->course_profile_idcourse_profile, $this->db));
	}
	public function testUpdate()
	{
	}
	
	public function testDelete()
	{
	}

}	
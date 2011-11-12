<?php

// Main WebNaplo Test Class file
require_once("WebNaploTest.php");

// Including the Model files
require_once("../models/Student.php");

class StudentTest extends WebNaploTest {

	public $student;
	public $db;
	
	public function __construct() {
		$this->db = $this->initDB();
		$this->student = new Student;
	}
	
	// Negative test for 
	public function testNegativeStudentDelete() {
		$this->assertEquals(0, Student::Delete(200008000,$this->db));
	}
}
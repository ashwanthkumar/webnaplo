<?php

// Main WebNaplo Test Class file
require_once("WebNaploTest.php");

// Including the Model files
require_once("../models/Student.php");

/**
 *	Test cases for unit testing the Student Model
 *
 *	@author Team Webnaplo
 *	@date 25/11/2011
 **/
class StudentModelTest extends WebNaploTest {

	public $db;
	
	public function __construct() {
		$this->db = $this->initDB();
	}
	
	// Negative test for deleting a non-existent student
	public function testNegativeStudentDelete() {
		$this->assertEquals(0, Student::Delete(123094527034098,$this->db));
	}
	
	// Test the students against insterting a new value using the Model::save()
	public function testStudentSave() {
		$student = new Student;
		
		$student->idstudent = mt_rand();
		$student->address = "Sample Address being added for testing";
		$student->current_semester = mt_rand(1,8);
		$student->email = "student.email@src.sastra.edu";
		$student->is_blocked = 0;
		$student->mobile = '1234567890';
		$student->name = 'Some Student Name';
		$student->password = 'src';
		$student->year = 4;
		$student->class_id = 1;
		
		$this->assertEquals(1, $student->save($this->db));
		
		// Now to remove the added student
		$this->assertEquals(1, Student::Delete($student->idstudent, $this->db));
	}
	
	//  Testing if the Student Block is working
	public function testStudentBlock() {
		$this->assertEquals(0, Student::block(909876543,$this->db));
		$this->assertEquals(1, Student::unblock(200000052,$this->db));
		$this->assertEquals(1, Student::block(200000052,$this->db));
	}
}

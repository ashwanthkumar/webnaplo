<?php

// Main WebNaplo Test Class file
require_once("WebNaploTest.php");

// Including the Model files
require_once("../models/Department.php");

/**
 *	Test cases for unit testing the Department Model
 *
 *	@author Team Webnaplo
 *	@date 25/11/2011
 **/
class DepartmentModelTest extends WebNaploTest {

	public $db;
	
	public function __construct() {
		$this->db = $this->initDB();
	}
	
	/**
	 *	Negative test for deleting a non-existent student
	 *	@test
	 *	@group negative
	 **/
	public function delete() {
		$this->assertEquals(0, Department::Delete(9999999999999,$this->db));
	}
	
	/**
	 *	Test the students against insterting a new value using the Model::save()
	 *
	 *	@test
	 *	@group positive
	 **/
	public function save() {
		$dept = new Department;
		$dept->name = "DepartmentRandom Name" . mt_rand();
		
		$r = $dept->save($this->db);
		
		// Testing that the transaction was not a failure
		$this->assertEquals(false, is_object($r));
		$this->assertNotInstanceOf('PDOException', $r);
		// Verifing its a positively only one
		$this->assertEquals(1, $r);
		
		// Verify the Department::getId()
		$dept->iddept = $this->db->lastInsertId();
		$staticDeptId = Department::getId($dept->name, $this->db);
		// Check if both the PK values are equal
		$this->assertEquals($dept->iddept, $staticDeptId);
		
		
		// Now to delete the entity
		$this->assertEquals(1, Department::Delete($dept->iddept, $this->db));
	}
	
	/**
	 *	Testing if the Department Search is working
	 *
	 *	@test
	 *	@group positive
	 **/
	public function search() {
		$deptList = $this->db->select("dept");
		$deptSearchList = Department::search($this->db);
		
		$this->assertEquals(count($deptList), count($deptSearchList));
	}
}
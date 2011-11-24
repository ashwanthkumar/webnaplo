<?php

// Main WebNaplo Test Class file
require_once("WebNaploTest.php");

// Include the PHPExcel Library
require_once("../lib/phpexcel/PHPExcel.php");

// Including the Model files
require_once("../models/Student.php");
require_once("../models/Staff.php");
require_once("../models/Department.php");
require_once("../models/Course.php");
require_once("../models/Programme.php");

/**
 *	Test cases for unit testing the ExcelRead using PHPExcel
 *
 *	@author Team Webnaplo
 *	@date 23/11/2011
 **/
class ExcelReadTest extends WebNaploTest {

	public $db;

	/**
	 *	Initialize the DB
	 **/
	public function __construct() {
		$this->db = $this->initDB();
	}

	/**
	 *	Test the reading of Excel documents for students
	 *	@group read
	 *	@test
	 **/
	public function readStudentExcel() {
		$this->readStudentExcelFiles('./data/StudentListTest.xlsx');
		$this->readStudentExcelFiles('./data/StudentListTest.xls');
		$this->readStudentExcelFiles('./data/StudentListTest.csv');
		
		// $this->markTestIncomplete("Test ODS file");
	}
	
	/**
	 *	Read and asserts the Student List (Import) file
	 **/
	private function readStudentExcelFiles($filename) {
		// Read from any of the supported files directly
		$objPHPExcel = PHPExcel_IOFactory::load($filename);

		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		// Contains the list of ids which will be generated upon inserting into the database
		$student_insert_ids = array();
		$file_column_mapping = array('A' => 'name', 'B' => 'registernumber', 'C' => 'year', 'D' => 'semester', 'E' => 'mobile', 'F' => 'email', 'G' => 'address');
		
		foreach($rowIterator as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(true);

			//skip first row -- Since its the heading
			if(1 === $row->getRowIndex()) {
				foreach($cellIterator as $cell) {
					if('name' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'name';
					} else if('registernumber' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'registernumber';
					} else if('year' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'year';
					} else if('semester' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'semester';
					} else if('mobile' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'mobile';
					} else if('email' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'email';
					} else if('address' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'address';
					}
				}
				continue;
			}

			// Getting zero-based row index
			$rowIndex = $row->getRowIndex() - 2;
			$array_data[$rowIndex] = array('name' => '', 'registernumber' => '', 'year' => '', 'semester' => '', 'mobile' => '', 'email' => '', 'address' => '');
			
			// Get the data from the sheet
			foreach($cellIterator as $cell) {
				$prop = $file_column_mapping[$cell->getColumn()];
				$array_data[$rowIndex][$prop] = $cell->getValue();
			}
			
			// Insert the Student Data into DB
			// Map the Excel File fields to Student Model fields
			$student_post_data = array(
									'class_id' => 1, 
									'year' => $array_data[$rowIndex]['year'],
									'idstudent' => $array_data[$rowIndex]['registernumber'],
									'name' => $array_data[$rowIndex]['name'],
									'email' => $array_data[$rowIndex]['email'],
									'address' => $array_data[$rowIndex]['address'],
									'mobile' => $array_data[$rowIndex]['mobile'],
									'current_semester' => $array_data[$rowIndex]['semester']
								);
			
			$r = Student::LoadAndSave($student_post_data, $this->db);
			
			$this->assertNotInstanceOf('PDOException', $r);	// Make sure its not an error
			$this->assertEquals(false, is_object($r));	// Make sure its not an error
			
			if(!is_object($r)) $student_insert_ids[] = $array_data[$rowIndex]['registernumber'];
		}
		
		// Test Data contains 6 records apart from the initial row
		$this->assertEquals(1, count($array_data));
		
		// Lets test if the data is actually read properly
		$this->assertEquals('Ashwanth', $array_data[0]['name']);
		$this->assertEquals('21203015', $array_data[0]['registernumber']);
		$this->assertEquals('4', $array_data[0]['year']);
		$this->assertEquals('8', $array_data[0]['semester']);
		$this->assertEquals('9003290112', $array_data[0]['mobile']);
		$this->assertEquals('ashwanthkumar@googlemail.com', $array_data[0]['email']);
		
		// Now delete the inserted fields from the datastore
		foreach($student_insert_ids as $sid) {
			$r = Student::Delete($sid, $this->db);
			$this->assertEquals(1, $r);
		}
	}

	/**
	 *	Test the reading of Excel documents for Staff
	 *	@group read
	 *	@test
	 **/
	public function readStaffExcel() {
		$this->markTestIncomplete("Yet to write this test");
	}

	/**
	 *	Test the reading of Excel documents for Course
	 *	@group read
	 *	@test
	 **/
	public function readCourseExcel() {
		$this->markTestIncomplete("Yet to write this test");
	}
	
	/**
	 *	@test
	 *	@group read
	 *	@output_buffering on
	 **/
	public function readDepartmentExcel() {
		// Do the testing across all the possible file formats
		$this->readDepartmentExcelFiles("./data/DepartmentListTest.xlsx");
		$this->readDepartmentExcelFiles("./data/DepartmentListTest.xls");
		$this->readDepartmentExcelFiles("./data/DepartmentListTest.csv");
		
		// $this->markTestIncomplete("Still need to test ODS files");
	}

	/**
	 *	Test the reading of Excel documents for Department
	 **/
	private function readDepartmentExcelFiles($filename) {
		// Read from any of the supported files directly
		$objPHPExcel = PHPExcel_IOFactory::load($filename);

		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		// Contains the list of ids which will be generated upon inserting into the database
		$dept_insert_ids = array();
		
		foreach($rowIterator as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(true);

			//skip first row -- Since its the heading
			if(1 === $row->getRowIndex()) {
				continue;
			}

			$rowIndex = $row->getRowIndex();
			$array_data[$rowIndex] = array('name'=>'');
			
			foreach($cellIterator as $cell) {
				// Assuming the data is present in the first cell
				if('A' == $cell->getColumn()){
					$array_data[$rowIndex]['name'] = $cell->getValue();
					
					$r = Department::LoadAndSave($array_data[$rowIndex], $this->db);
					
					// Assert that the operation is valid
					$this->assertEquals(false, is_object($r)); // First condition for being an error PDOException
					
					if(is_object($r) == false && $r != false) $dept_insert_ids[] = $this->db->lastInsertId(); // Save the PK to the array for later removal
				}
			}
		}
		// Test Data contains 6 records apart from the initial row
		$this->assertEquals(6, count($array_data));
		$this->assertEquals(6, count($dept_insert_ids));
		
		// Lets test if the data is actually read properly
		$this->assertEquals('Department1', $array_data[2]['name']);
		$this->assertEquals('Department2', $array_data[3]['name']);
		$this->assertEquals('Department3', $array_data[4]['name']);
		$this->assertEquals('Department4', $array_data[5]['name']);
		$this->assertEquals('Department5', $array_data[6]['name']);
		$this->assertEquals('Department6', $array_data[7]['name']);
		
		
		// Delete all the newly created departments from the datastore
		foreach($dept_insert_ids as $did) {
			$r = Department::Delete($did, $this->db);
			$this->assertEquals(1, $r);
		}
	}

	/**
	 *	Test the reading of Excel documents for Programme
	 *	@group read
	 *	@test
	 **/
	public function readProgrammeExcel() {
		$this->markTestIncomplete("Yet to write this test");
	}
}
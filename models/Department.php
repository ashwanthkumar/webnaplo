<?php

/**
 *	Department Model class
 *	
 *	@author Team Webnaplo
 *	@date 19/11/2011
 *
 *	@table	dept
 **/
class Department {

	public $iddept;
	public $name;
	
	/**
	 *	Save the current instance of the model object to the datastore
	 *
	 *	@return 1 If successful, else PDOException Object on failure
	 **/
	public function save($db) {
		$r= $db->insert("dept", array("name" => $this->name));
		if(is_object($r) && get_class($r) == "PDOException") return $r;
		
		$this->iddept = $db->lastInsertId();
		return $r;
	}
	
	/**
	 *	Update the current instance of the model object
	 *
	 *	@return 1 if successful, else PDOException Object on failure
	 **/
	public function update($db) {
		return $db->update("dept", array("name" => $this->name), "iddept = :did", array(":did" => $this->iddept));
	}
	
	/**
	 *	Loads and saves the current deparment object instances
	 *	
	 *	@param	$department	$_POST content from the department page or user modified array
	 *	@param	$db			PDOObject Instance
	 *
	 *	@return 1 on success, PDOExcpetion Object on failure
	 **/
	public static function LoadAndSave($department, $db, &$dept_object = null) {
		extract($department);
		
		$deptList = $db->select("dept", "name = :name", array(":name" => $name));
		
		if(count($deptList) < 1) {
			$d = new Department;
			if(isset($name)) $d->name = $name;
		
			$r = $d->save($db);

			$dept_object = $d;
			
			return $r;
		} else {
			$dept_object = null;
			return false;
		}
	}

	/**
	 *	Delete the current instance of the Department object
	 *
	 *	@param	$dip	Department ID
	 *	@param	$db		PDOObject Instance
	 *
	 *	@return 1 on successful operation, PDOException if any error
	 **/
	public static function Delete($dip, $db) {
		return $db->delete("dept", "iddept = :dip", array(":dip" => $dip));
	}
	
	/**
	 *	Utility function that gets the ID of the department from its name. (Since all department names are unique). This function does the exact match of the department. 
	 *
	 *	@param	$dept_name	Department name to be searched for (Name is case-sensitive)
	 *	@param	$db			PDOObject Instance
	 *
	 *	@return DepartmentID 
	 **/
	public static function getId($dept_name, $db) {
		$deptList = $db->select("dept", "name = :name", array(":name" => $dept_name));
		
		$deptCount = count($deptList); 
		if($deptCount < 1) {
			// No valid Department found
			return false;
		} else if($deptCount > 1) {
			// More than one department with the same name
			return false;
		} else {
			// Exact match found, return the ID
			$d = $deptList[0];
			return $d['iddept'];
		}
		
		// I should not come here
		return false;
	}

	/**
	 *	Utility function that gets the Name of the department from its Id.
	 *
	 *	@param	$dept_id	Department id 
	 *	@param	$db			PDOObject Instance
	 *
	 *	@return DepartmentName 
	 **/
	public static function getName($dept_id, $db) {
		$deptList = $db->select("dept", "iddept = :did", array(":did" => $dept_id));
		
		$deptCount = count($deptList); 
		if($deptCount < 1) {
			// No valid Department found
			return false;
		} else if($deptCount > 1) {
			// More than one department with the same name
			return false;
		} else {
			// Exact match found, return the ID
			$d = $deptList[0];
			return $d['name'];
		}
		
		// I should not come here
		return false;
	}
	
	/**
	 *	Search through all the entities of the model
	 *
	 *	@param	$db			PDOObject
	 *	@param	$condition	Condition on which the object must be searched
	 *	@param	$bind		Bind the values used in the $condition
	 *
	 *	@return	Array of entities that matches the condition
	 **/
	public static function search($db, $condition = '1=1', $bind = array()) {
		return $db->select("dept", $condition, $bind);
	}

	/**
	 *	Imports the Department List to the datastore. Supported file types are - 
	 *				-->	XLSX
	 *				-->	XLS
	 *				-->	CSV
	 *
	 *	@linkedTestId	TODO
	 *	
	 *	@param	$filename	Filename (with full path) to read from
	 *	@param	$db			PDOObject
	 **/
	public static function Import($filename, $db) {
		// Read from any of the supported files directly
		$objPHPExcel = PHPExcel_IOFactory::load($filename);

		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		// Contains the list of ids which will be generated upon inserting into the database
		$dept_insert_ids = array();
		$file_column_mapping = array('A' => 'name');
		$batch_errors = array();
		
		foreach($rowIterator as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(true);

			//skip first row -- Since its the heading
			if(1 === $row->getRowIndex()) {
				foreach($cellIterator as $cell) {
					if('name' == strtolower($cell->getValue())) {
						$file_column_mapping[$cell->getColumn()] = 'name';
					}
				}
				continue;
			}

			// Getting zero-based row index
			$rowIndex = $row->getRowIndex() - 2;
			$array_data[$rowIndex] = array('name' => '');
			
			// Get the data from the sheet
			foreach($cellIterator as $cell) {
				$prop = $file_column_mapping[$cell->getColumn()];
				$array_data[$rowIndex][$prop] = $cell->getValue();
			}
			
			// Insert the Department Data into DB
			// Map the Excel File fields to Staff Model fields
			$dept_load_array = array(
									'name' => $array_data[$rowIndex]['name'],
								);
			
			$r = Department::LoadAndSave($dept_load_array, $db);
			
			if(!is_object($r) && $r != false) $dept_insert_ids[] = strtoupper($array_data[$rowIndex]['name']);
			else {
				$deptId = $array_data[$rowIndex]['name'];
				if(is_object($r)) $batch_errors[$deptId] = $r->getMessage(); 
				else $batch_errors[$deptId] = $array_data[$rowIndex]['name'] . " already exist.";
			}
		}
		// Return the batch errors if any
		return $batch_errors;
	}
}

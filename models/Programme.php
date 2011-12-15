<?php

/**
 *	Programme Model
 **/
class Programme{

	public $idprogramme;
	public $name;
	public $dept_id;
	
	/** 
	 *	Save the current instance of the Programme in the datastore
	 *
	 *	@param	$db	PDOObject
	 **/
	public function save($db) {
		$r= $db->insert("programme", array(
				"name" => strtoupper($this->name),
				"dept_id" => $this->dept_id
			));
		if(is_object($r) && get_class($r) == "PDOException") return $r;
		
		// Get the value of AUTO_INCREMENT value from the last insert and set it as the current objects ID
		$this->idprogramme = $db->lastInsertId();
		return 1;
	}
	
	/**
	 *	Updates the current instance of the Programme
	 *
	 *	@param	$db		PDOObject
	 **/
	public function update($db) {
		return $db->update("programme", array(
				"name" => strtoupper($this->name),
				"dept_id" => $this->dept_id
			), "idprogramme = :pid", array(":pid" => $this->idprogramme));
	}
	
	/**
	 *	Loads an instance of the Programme from the datastore
	 *
	 *	@param	$pgm_id		Programme to retrieve
	 *
	 *	@return	Programme Object if $pgm_id is found, else FALSE
	 **/
	public static function load($pgm_id, $db) {
		$pgm = $db->select("programme", "idprogramme = :pid", array(":pid" => $pgm_id));
		
		if(count($pgm) < 1) return false;
		
		extract($pgm[0]);
		$programme = new Programme;
		$programme->idprogramme = $idprogramme;
		$programme->name = $name;
		$programme->dept_id = $dept_id;
		
		return $programme;
	}

	/**
	 *	Load and update the instance of the object from the datastore
	 *
	 *	@param	$pgm				Array of properties of the Programme
	 *	@param	$db					PDOObject
	 *	@param	&$programme_object	Obect to return the optional Programme Instance object after updating
	 **/
	public static function LoadAndUpdate($pgm, $db, &$programme_object = null) {
		extract($pgm);

		$programme = Programme::load($idprogramme);
		if(isset($name))	$programme->name = $name;
		if(isset($dept_id))	$programme->dept_id = $dept_id;
		
		$r = $programme->update($db);	
		
		$programme_object = $programme;
		
		return $r;
	}

	/**
	 *	Load and Save the instance of Programme Entity.
	 *
	 *	@param	$pgm				Array of Properties of the Programme
	 *	@param	$db					PDOObject
	 *	@param	$programme_object	Reference object that can be set after saving the object
	 **/
	public static function LoadAndSave($pgm, $db, &$programme_object = null) {
		extract($pgm);

		$p = $db->select("programme", "name = :name and dept_id = :did", array(":name" => strtoupper($name), ":did" => $dept_id));
		if(count($p) > 0) return FALSE;
		
		$programme = new Programme;
		$programme->name = $name;
		$programme->dept_id = $dept_id;
		
		$r = $programme->save($db);		
		
		$programme_object = $programme;
		
		return $r;
	}
	
	/**
	 *	Delete a Programme instance from the datastore
	 *
	 *	@param	$pid	Programme Id
	 *	@return	1 if successful, else PDOException object in case of an error
	 **/
	public static function Delete($pid, $db) {
		return $db->delete("programme", "idprogramme = :pid", array(":pid" => $pid));
	}
	
	/**
	 *	Imports the Programme List to the datastore. Supported file types are - 
	 *				-->	XLSX
	 *				-->	XLS
	 *				-->	CSV
	 *
	 *	@linkedTestId	TODO
	 *	
	 *	@param	$filename	Filename (with full path) to read from
	 *	@param	$dept		Department where the current programme list belongs
	 *	@param	$db			PDOObject
	 **/
	public static function Import($filename, $dept, $db) {
		// Read from any of the supported files directly
		$objPHPExcel = PHPExcel_IOFactory::load($filename);

		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		// Contains the list of ids which will be generated upon inserting into the database
		$programme_insert_ids = array();
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
			
			// Insert the Programme Data into DB
			// Map the Excel File fields to Staff Model fields
			$programme_load_array = array(
									'name' => $array_data[$rowIndex]['name'],
									'dept_id' => $dept, // Department value got from the form
								);
			
			$r = Programme::LoadAndSave($programme_load_array, $db);
			
			if(!is_object($r) && $r != false) $programme_insert_ids[] = strtoupper($array_data[$rowIndex]['name']);
			else {
				$pgmId = $array_data[$rowIndex]['name'];
				if(is_object($r)) $batch_errors[$pgmId] = $r->getMessage(); 
				else $batch_errors[$pgmId] = $array_data[$rowIndex]['name'] . " already exist.";
			}
		}
		// Return the batch errors if any
		return $batch_errors;
	}

}

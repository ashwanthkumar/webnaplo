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
}


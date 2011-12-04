<?php

require_once("../lib/class.db.php");

class WebNaploTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * Initialize the PDO library
	 *
	 *	@test
	 **/
	public function initDB() {
		include "../config.php";
		$db = new db("mysql:host=$db_host;port=$db_port;dbname=$db_name", "$db_user", "$db_pass");
		// Sample test that is to be run in order to execute the directory test
		$this->assertTrue(true);
		
		return $db;
	}
	
	/**
	 *	Get the timestamp of the $time in MySQL format
	 *
	 *	@param	$time	Any acceptable value to strtotime, that needs to be converted into MySQL timestamp format. 
	 **/
	public function timestamp($time) {
		if(is_string($time)) $time = strtotime($time);
		return date("Y-m-d H:i:s", $time);
	}
}

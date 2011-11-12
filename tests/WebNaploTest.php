<?php

require_once("../lib/class.db.php");

class WebNaploTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * Initialize the PDO 
	 **/
	public function initDB() {
		// Configuration file for the entire application
		$db_host = "localhost";	// Databse host to connect to
		$db_port = 3306;	// Database port number to connect to
		$db_user = "root";	// Database User
		$db_pass = "";	// Database password
		
		$db_name = "webnaplo";	// Name of the database
		$db = new db("mysql:host=$db_host;port=$db_port;dbname=$db_name", "$db_user", "$db_pass");
		
		return $db;
	}
}

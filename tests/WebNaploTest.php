<?php

require_once("../lib/class.db.php");

class WebNaploTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * Initialize the PDO library
	 **/
	public function initDB() {
		include "../config.php";
		$db = new db("mysql:host=$db_host;port=$db_port;dbname=$db_name", "$db_user", "$db_pass");
		
		return $db;
	}
}

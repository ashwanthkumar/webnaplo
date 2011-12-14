<?php

/**
 *	This corn job is executed periodically to ensure that the staff who does not login, all their posting rights revoked. 
 *
 *	@author		Ashwanth Kumar <ashwanth@ashwanthkumar.in>
 *	@version 	0.1
 *	@package	Scripts
 **/

// Define the maximum time before which the staff has to login
define('MAX_INTERVAL', '6 days ago');

// Include the PDO Wrapper class
require_once("../lib/class.db.php");
// Include the Staff Model class
require_once("../models/Staff.php");
// Include the config file
require_once("../config.php");

// Create the $db instance 
$db = new db("mysql:host=$db_host;port=$db_port;dbname=$db_name", "$db_user", "$db_pass");

$staff_list = Staff::search($db);

foreach($staff_list as $staff) {
	$staff_id = $staff['idstaff']; // Get the Value used as FK (Primary Key of the Staff Table)
	$last_login = strtotime($staff['last_login']);	 // Stored as int as in time()
	$now = time();
	
	$update_interval = strtotime(MAX_INTERVAL);
	
	if($update_interval > $last_login) {
		// Lock all the items of the staff
		$update_status = $db->run("update lock_unlock set assignment = 1, attendance = 1, cia_1 = 1, cia_2 = 1, cia_3 = 1 where cp_id in (select idcourse_profile from course_profile where staff_id = :sid)", array(":sid" => $staff_id));

		/**
		 *	Call any hooks or custom functions here. Even configure the project to use a lib like log4php to log all activities
		 **/
	} else {
		// Skip this staff member and iterate to the next
		continue;
	}
}

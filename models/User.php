<?php

/**
 *	Model Entity that represents the User of the system in the Webnaplo
 *
 *	@since 1.0
 **/
class User {
	// Current name of the User
	public $name;
	// Is the User Authenticated
	public $auth;
	/**
	 *	Unique User id of the user
	 *	
	 *	For Students - Register Number (idstudent)
	 *	For Staff - Staff ID (staff_id not the PK)
	 *	For DataEntry - Username of the Dataentry User
	 *	For Admin - Username of the Admin User
	 **/
	public $userid;
	// Type of User - admin > dataentry > staff > student
	public $type;
	// Is the currently logged in user blocked?
	public $blocked;
	// Current Access Level of the User
	public $accessLevel;
	
	public function __construct() {
		$this->auth = false;
		$this->accessLevel = -1;
	}
	
	public function getLoggedIn() {
		return $this->auth;
	}
	
	public function isBlocked() {
		return ($this->blocked) ? true: false;
	}
	
	public function isStudent() {
		return ($this->type == "student") ? true : false;
	}

	public function isStaff() {
		return ($this->type == "staff") ? true : false;
	}
	
	public function isAdmin() {
		return ($this->type == "admin") ? true : false;
	}
	
	public function isDataEntry() {
		return ($this->type == "dataentry") ? true : false;
	}
	
	public function getType() {
		return $this->type;
	}

	/**
	 *	Load the User from the Session to the Object.
	 *
	 *	@reason Provided as a fix for session object store / retrieve problem
	 **/
	public static function load($user) {
		$u = new User;
		if(isset($user['name']))	$u->name = $user['name'];
		if(isset($user['auth']))	$u->auth = $user['auth'];
		if(isset($user['userid']))	$u->userid = $user['userid'];
		if(isset($user['type']))	$u->type = $user['type'];
		if(isset($user['blocked']))	$u->blocked = $user['blocked'];
		if(isset($user['accessLevel']))	$u->accessLevel = $user['accessLevel'];
		
		return $u;
	}
}
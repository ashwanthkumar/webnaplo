<?php

class User {
	public $name;
	public $auth;
	public $userid;
	public $type;
	public $blocked;
	
	public function __construct() {
		$this->auth = false;
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
	
	public static function load($user) {
		$u = new User;
		if(isset($user['name']))	$u->name = $user['name'];
		if(isset($user['auth']))	$u->auth = $user['auth'];
		if(isset($user['userid']))	$u->userid = $user['userid'];
		if(isset($user['type']))	$u->type = $user['type'];
		if(isset($user['blocked']))	$u->blocked = $user['blocked'];
		
		return $u;
	}
	
	public function destroy() {
		$this->name = null;
		$this->auth = false;
		$this->userid = null;
		$this->type = null;
	}
}
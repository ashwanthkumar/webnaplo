<?php

/**
 *	Render the Home Page (Login Page), if the user is already authenticated then redirect them to the corresponding home page
 *
 *	@method GET / POST
 *	@route	/*	(Used as the last option only when no other parameters match the route controller pattern)
 **/
function webnaplo_home() {
	if(!isset($_SESSION['user'])) {
		return redirect('/user/login');
	} else {
		$user = get_object_vars ($_SESSION['user']);
		// print_r($user);
		return redirect($user['type'] . '/home');
	}
}

/**
 *	Render the User Login Page
 *	
 *	@method GET
 *	@route /user/login
 **/
function user_login() {
	if(!isset($_SESSION['user'])) {
		return render('/webnaplo/login.html.php');
	} else {
		$user = get_object_vars ($_SESSION['user']);
		// print_r($user);
		return redirect($user['type'] . '/home');
	}
}

/**
 *	Logout the currently logged in user
 *
 *	@method GET / POST
 *	@route 	/user/logout
 **/
function user_logout() {
	unset($_SESSION['user']);
	return redirect('/user/login');
}

/**
 *	Authenticate the user from the Login page
 *
 *	@method POST
 *	@route 	/user/login
 **/
function user_login_authenticate() {
	extract($_POST);

	$dataentry_username = Configuration::get(Configuration::$CONFIG_DATAENTRY_USER, $GLOBALS['db']);
	if(is_object($dataentry_username) && get_class($dataentry_username) != "PDOException") echo $dataentry_username->getMessage(); 
	$dataentry_username = $dataentry_username[0]["value"];
	$dataentry_password = Configuration::get(Configuration::$CONFIG_DATAENTRY_PASSWORD, $GLOBALS['db']);
	$dataentry_password = $dataentry_password[0]["value"];
	
	$admin_username = Configuration::get(Configuration::$CONFIG_ADMIN_USER, $GLOBALS['db']);
	$admin_username = $admin_username[0]["value"];
	$admin_password = Configuration::get(Configuration::$CONFIG_ADMIN_USER, $GLOBALS['db']);
	$admin_password = $admin_password[0]["value"];

	$db = $GLOBALS['db'];
	
	$user = new User;
	if($username == $dataentry_username) {
		$user->type = "dataentry";
		$user->name = "Dataentry User";
		$user->auth = ($password == $dataentry_password) ? true : false;
		if($user->auth) {
			$_SESSION['user'] = $user;
			return redirect('/dataentry/home');
		} else {
			flash('error', "Invalid Username or Password combination");
			return redirect('/user/login');
		}	
	} else if($username == $admin_username) {
		$user->type = "admin";
		$user->name = "Admin User";
		$user->auth = ($password == $admin_password) ? true : false;
		if($user->auth) {
			$_SESSION['user'] = $user;
			return redirect('/admin/home');
		} else {
			flash('error', "Invalid Username or Password combination");
			return redirect('/user/login');
		}
		
	} else {
		// Check for staff id pattern in username
		preg_match("/[a-zA-Z]+[0-9]+/", $username, $matchs);
		if(count($matchs) > 0) {
			$user->type = "staff";
			$staff = $db->select("staff", "staff_id = :staffid and password = :pass", array(":staffid" => $username, ":pass" => $password));
			
			if(count($staff) > 0) {
				$staff = $staff[0];
				if($staff["is_blocked"] == 1) {
					$user->auth = false;
					$user->blocked = true;
					flash("error", "Sorry but your account is blocked. Please contact WebNaplo Admin to unlock your Account.");
					return redirect('/user/login');
				} else {
					$user->auth = true;
					$user->blocked = false;
					$user->name = $staff['name'];
					$user->userid = $staff['idstaff'];
					
					$_SESSION['user'] = $user;
					$_SESSION[$user->type] = $staff;
					return redirect('/staff/home');
				}
			} else {
				$user->auth = false;
				flash("error", "Invalid Username or Password combination");
				return redirect('/user/login');
			}
		} else {
			// Current pattern of username is Student
			$user->type = "student";
			$student = $db->select("student", "idstudent = :sid and password = :pass", array(":sid" => $username, ":pass" => $password));
			
			if(count($student) > 0) {
				$student = $student[0];
				if($student["is_blocked"] == 1) {
					$user->auth = false;
					$user->blocked = true;
					flash("error", "Sorry but your account is blocked. Please contact WebNaplo Admin to unlock your Account.");
					return redirect('/user/login');
				} else {
					$user->auth = true;
					$user->blocked = false;
					$user->name = $student['name'];
					$user->userid = $student['idstudent'];

					$_SESSION['user'] = $user;
					$_SESSION[$user->type] = $student;
					
					return redirect('/student/home');
				}
			} else {
				$user->auth = false;
				flash("error", "Invalid Username or Password combination");
				return redirect('/user/login');
			}
			// Common for other errors	
			return redirect('/user/login');
		}
	}
		
}

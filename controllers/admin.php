<?php

/**
 * Render the Home Page - Dashboard of the Admin User 
 *
 *	@method GET
 *	@route /admin/home
 **/
function admin_home_render() {
	layout('admin/layout.html.php');
	set('title', 'Admin Home');
	set('home_active', 'true');
	
	return render("admin/admin.home.html.php");
}

/**
 * Render the Lock and Unlock Page for the Admin
 *
 *	@method GET
 *	@route /admin/lock/
 **/
function admin_lock_render() {
	layout('admin/layout.html.php');
	set('title', 'Admin - Lock and Unlock Status');
	set('lock_active', 'true');
	
	return render("admin/admin.lock.html.php");
}

/**
 * Lock a particular type of object in the system for the given class
 *
 *	@metod GET
 *	@route ^/admin/lock_unlock/(\d+)/(\d+)/lock
 **/
function admin_lock_entity() {
	$type = params(0);
	$id = params(1);
	
	$r = LockUnLock::lock($type, $id, $GLOBALS['db']);
	
	return redirect("admin/lock");
}

/**
 * 	Unlock a particular type of object in the system for the given class
 *
 *	@method GET
 * 	@route ^/admin/lock_unlock/(\d+)/(\d+)/unlock
 **/
function admin_unlock_entity() {
	$type = params(0);
	$id = params(1);
	
	print_r($type);
	print_r($id);
	$r = LockUnLock::unlock($type, $id, $GLOBALS['db']);
	
	return redirect("admin/lock");
}

/**
 * Render custom javascript for Admin Interface
 *
 *	@method GET
 * 	@route /admin/js/
 **/
function admin_js_render() {
	return js('admin/admin_js.php');
}

/**
 * Block or Unblock selected group of staff users
 *
 *	@method POST
 *	@route /admin/staff/block
 **/
function admin_staff_block_post() {
	$students = $_POST['staff_profile'];
	$db = $GLOBALS['db'];
	
	switch($_POST['operation']) {
	case "block":
		while($student = current($students)) {
			$db->update("staff", array("is_blocked" => '1'), "idstaff = :sid", array(":sid" => key($students)));

			next($students);
		}
		flash('success', "Selected students have been blocked");
		break;
	
	case "unblock":
		while($student = current($students)) {
			$db->update("staff", array("is_blocked" => '0'), "idstaff = :sid", array(":sid" => key($students)));
			
			next($students);
		}
		flash('success', "Selected students have been unblocked");
		break;
	}
	
	return redirect('admin/block_unblock');
}

/**
 *	Block or Unblock selected group of Student users
 *
 *	@method POST
 *	@route /admin/student/block
 **/
function admin_student_block_post() {
	$students = $_POST['student_profile'];
	$db = $GLOBALS['db'];
	
	switch($_POST['operation']) {
	case "block":
		while($student = current($students)) {
			$db->update("student", array("is_blocked" => '1'), "idstudent = :sid", array(":sid" => key($students)));

			next($students);
		}
		flash('success', "Selected students have been blocked");
		break;
	
	case "unblock":
		while($student = current($students)) {
			$db->update("student", array("is_blocked" => '0'), "idstudent = :sid", array(":sid" => key($students)));
			
			next($students);
		}
		flash('success', "Selected students have been unblocked");
		break;
	}
	
	return redirect('admin/block_unblock');
}

/**
 * Render Block/Unblock Page for the Admin
 *
 * 	@method GET
 *	@route /admin/block_unblock/
 **/
function admin_block_unblock_render() {
	layout('admin/layout.html.php');
	set('title', 'Admin - Block or Unblock Users');
	set('block_active', 'true');
	
	return render("admin/admin.blockunblock.html.php");
}

/**
 *	Block a particular Staff User
 *
 *	@method GET
 *	@route ^/admin/staff/(\d+)/block
 **/
function admin_staff_block() {
	$staffid = params(0);
	$db = $GLOBALS['db'];
	
	$db->update("staff", array("is_blocked" => '1'), "idstaff = :sid", array(":sid" => $staffid));
	
	flash('success', "Staff has been blocked");
	return redirect('admin/block_unblock');
}

/**
 *	Unblock a particular Staff User
 *
 *	@method GET
 *	@route	^/admin/staff/(\d+)/unblock
 **/
function admin_staff_unblock() {
	$staffid = params(0);
	$db = $GLOBALS['db'];
	
	$db->update("staff", array("is_blocked" => '0'), "idstaff = :sid", array(":sid" => $staffid));
	
	flash('success', "Staff has been unblocked");
	return redirect('admin/block_unblock');
}

/**
 *	Block a particular Student User
 *
 *	@method GET
 *	@route ^/admin/student/(\d+)/block
 **/
function admin_student_block() {
	$studid = params(0);
	$db = $GLOBALS['db'];

	$db->update("student", array("is_blocked" => '1'), "idstudent = :sid", array(":sid" => $studid));
	
	flash('success', "Student has been blocked");
	return redirect('admin/block_unblock');
}

/**
 *	Unblock a particular Student user
 *
 *	@method GET
 *  @route ^/admin/student/(\d+)/unblock
 **/
function admin_student_unblock() {
	$studid = params(0);
	$db = $GLOBALS['db'];

	$db->update("student", array("is_blocked" => '0'), "idstudent = :sid", array(":sid" => $studid));
	
	flash('success', "Student has been unblocked");
	return redirect('admin/block_unblock');
}

/**
 *	Render the Admin Advanced Page
 *
 *	@method GET
 *	@route 	/admin/advanced/
 **/
function admin_advanced_render() {
	layout('/admin/layout.html.php');
	set('title', 'Admin Advanced');
	set('advanced_visible', 'true');
	
	return render('/admin/admin.advanced.html.php');
}

/**
 *	Reset a particular type of User's password
 *
 *	@method POST
 *	@route 	/admin/user/reset/
 **/
function admin_user_reset_password() {
	// return h("TODO Method");
	$username = $_POST['username'];
	
	$db = $GLOBALS['db'];
	
	// Check to make sure that username is not that of dataentry's or Admins
	$dataentry_username = 	Configuration::get(Configuration::$CONFIG_DATAENTRY_USER, $db, true);
	$admin_username 	=	Configuration::get(Configuration::$CONFIG_ADMIN_USER, $db,  true);
	
	if($username == $dataentry_username || $username == $admin_username) {
		flash('error', "You cannot Reset password for Dataentry or Admin. Use the form on the right. <a href='" . url_for('/docs/admin/advanced') . "'>View Help</a>");
		return redirect('/admin/advanced');
	} else {
		// Seems like not the admin or the dataenty user
		preg_match("/[a-zA-Z]+[0-9]+/", $username, $matchs);
		if(count($matchs) > 0) {
			$staff = $db->select("staff", "staff_id = :staffid", array(":staffid" => $username));
			
			if(count($staff) < 1) {
				flash('error', "Staff User ID - $username not found in the system.");
			} else {
				$default_staff_password = Configuration::get(Configuration::$CONFIG_DEFAULT_STAFF_PASSWORD,$db, true);
				$update = $db->update("staff", array("password" => $default_staff_password), "staff_id = :staffid", array(":staffid" => $username));

				flash('success', "Password successfully reset.");
				if(is_object($update) && get_class($update) == "PDOException") halt(SERVER_ERROR, $update->getMessage());
			}
		} else {
			$students = $db->select("student", "idstudent = :studid", array(":studid" => $username));
			
			if(count($students) < 1) {
				flash('error', "User ID - $username not found in the system.");
			} else {
				$default_student_password = Configuration::get(Configuration::$CONFIG_DEFAULT_STUDENT_PASSWORD,$db, true);
				$update = $db->update("student", array("password" => $default_student_password), "idstudent = :stuid", array(":stuid" => $username));
				flash('success', "Password successfully reset");
				if(is_object($update) && get_class($update) == "PDOException") halt(SERVER_ERROR, $update->getMessage());
			}
		}
		return redirect('admin/advanced');
	}
	// you should never come here
	// return h("");
	flash('warning', "Something unexpected happened here, Please try again");
	return redirect('admin/advanced');
}

/**
 *	Reset all Staff Password
 *	@method POST
 *	@route	/admin/user/reset/staff/all
 **/
function admin_staff_all_reset_password() {
	$db = $GLOBALS['db'];
	
	$default_staff_password = Configuration::get(Configuration::$CONFIG_DEFAULT_STAFF_PASSWORD,$db, true);
	$update = $db->update("staff", array("password" => $default_staff_password), "1=1"); // 1=1 is required for update query 

	flash('success', "Password successfully reset for all Staffs");
	if(is_object($update) && get_class($update) == "PDOException") halt(SERVER_ERROR, $update->getMessage());
	return redirect('admin/advanced');
}

/**
 *	Reset all Students Password
 *
 *	@method POST
 *	@route	/admin/user/reset/student/all
 **/
function admin_student_all_reset_password() {
	$db = $GLOBALS['db'];
	
	$default_student_password = Configuration::get(Configuration::$CONFIG_DEFAULT_STUDENT_PASSWORD,$db, true);
	$update = $db->update("student", array("password" => $default_staff_password), "1=1"); // 1=1 is required for update query 

	flash('success', "Password successfully reset for all Students");
	if(is_object($update) && get_class($update) == "PDOException") halt(SERVER_ERROR, $update->getMessage());
	return redirect('admin/advanced');
}

/**
 *	Change the Admin Password
 *
 *	@method POST
 *	@route /admin/user/admin/update/password
 **/
function admin_update_admin_password() {
	$db = $GLOBALS['db'];
	
	if(!isset($_POST['adminpassword']) || strlen(trim($_POST['adminpassword'])) < 1) {
		flash('warning', "Blank passwords are not supported in the system");
		return redirect("admin/advanced");
	}
	
	$password = $_POST['adminpassword'];
	
	Configuration::put(Configuration::$CONFIG_ADMIN_PASSWORD, $password, $db);
	flash('success', "Your Admin password is successfully changed");
	return redirect('admin/advanced');
}

/**
 *	Update the Dataentry password
 *
 *	@method POST
 *	@route /admin/user/dataentry/update/password
 **/
function admin_update_dataentry_password() {
	$db = $GLOBALS['db'];
	
	if(!isset($_POST['dataentryPassword']) || strlen(trim($_POST['dataentryPassword'])) < 1) {
		flash('warning', "Blank passwords are not supported in the system");
		return redirect("admin/advanced");
	}
	
	$password = $_POST['dataentryPassword'];
	
	Configuration::put(Configuration::$CONFIG_DATAENTRY_PASSWORD, $password, $db);
	flash('success', "Your Dataentry password is successfully changed");
	return redirect('admin/advanced');
}

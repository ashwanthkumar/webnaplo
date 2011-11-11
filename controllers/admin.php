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
	return h("TODO Method");
}

/**
 *	Reset all Staff Password
 *	@method POST
 *	@route	/admin/user/reset/staff/all
 **/
function admin_staff_all_reset_password() {
	return h("TODO Method");
}

/**
 *	Reset all Students Password
 *
 *	@method POST
 *	@route	/admin/user/reset/student/all
 **/
function admin_student_all_reset_password() {
	return h("TODO Method");
}
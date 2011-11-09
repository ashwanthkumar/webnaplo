<?php

function admin_home_render() {
	layout('admin/layout.html.php');
	set('title', 'Admin Home');
	set('home_active', 'true');
	
	return render("admin/admin.home.html.php");
}

function admin_lock_render() {
	layout('admin/layout.html.php');
	set('title', 'Admin - Lock and Unlock Status');
	set('lock_active', 'true');
	
	return render("admin/admin.lock.html.php");
}

function admin_lock_entity() {
	$type = params(0);
	$id = params(1);
	
	$r = LockUnLock::lock($type, $id, $GLOBALS['db']);
	
	return redirect("admin/lock");
}

function admin_unlock_entity() {
	$type = params(0);
	$id = params(1);
	
	print_r($type);
	print_r($id);
	$r = LockUnLock::unlock($type, $id, $GLOBALS['db']);
	
	return redirect("admin/lock");
}

function admin_js_render() {
	return js('admin/admin_js.php');
}

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

function admin_block_unblock_render() {
	layout('admin/layout.html.php');
	set('title', 'Admin - Block or Unblock Users');
	set('block_active', 'true');
	
	return render("admin/admin.blockunblock.html.php");
}

function admin_staff_block() {
	$staffid = params(0);
	$db = $GLOBALS['db'];
	
	$db->update("staff", array("is_blocked" => '1'), "idstaff = :sid", array(":sid" => $staffid));
	
	flash('success', "Staff has been blocked");
	return redirect('admin/block_unblock');
}

function admin_staff_unblock() {
	$staffid = params(0);
	$db = $GLOBALS['db'];
	
	$db->update("staff", array("is_blocked" => '0'), "idstaff = :sid", array(":sid" => $staffid));
	
	flash('success', "Staff has been unblocked");
	return redirect('admin/block_unblock');
}

function admin_student_block() {
	$studid = params(0);
	$db = $GLOBALS['db'];

	$db->update("student", array("is_blocked" => '1'), "idstudent = :sid", array(":sid" => $studid));
	
	flash('success', "Student has been blocked");
	return redirect('admin/block_unblock');
}

function admin_student_unblock() {
	$studid = params(0);
	$db = $GLOBALS['db'];

	$db->update("student", array("is_blocked" => '0'), "idstudent = :sid", array(":sid" => $studid));
	
	flash('success', "Student has been unblocked");
	return redirect('admin/block_unblock');
}


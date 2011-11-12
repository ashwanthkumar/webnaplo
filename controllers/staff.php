<?php

function staff_home_render() {
	layout('staff/layout.html.php');
	set("title" ,"Staff Home");
	set("home_active" ,"true");

    return render("staff/staff.home.html.php");
}

function staff_cp_add_render() {
	layout('staff/layout.html.php');
	set("title" ,"Staff - Add Course Profile");
	set("cp_active" ,"true");

    return render("staff/staff.cp.add.html.php");
}

function staff_cp_view_render() {
	layout('staff/layout.html.php');
	set("title" ,"Staff - Course Profile");
	set("cp_active" ,"true");

    return render("staff/staff.cp.view.html.php");
}

function staff_cp_delete() {
	$cp_id = params(0);
	$db = $GLOBALS['db'];

	$user = get_user();
	$r = $db->delete("course_profile", "idcourse_profile = :cip and staff_id = :sid", array(":cip" => $cp_id, ":sid" => $user->userid));
	
	if(is_object($r) && get_class($r) == "PDOException") {
		trigger_error("Error in Course Profile Delete", E_USER_ERROR);
	} else {
		if(count($r) > 0) {
			flash("success", "Course Profile $name has been successfully deleted");
			return redirect('/staff/course_profile/');
		} else {
			flash("warning", "Course Profile $name was not found in the system");
			return redirect('/staff/course_profile/');
		}
	}
	
	return redirect("staff/course_profile/");
}

function staff_cp_edit() {
	$cp_id = params(0);
	layout('staff/layout.html.php');
	set("title" ,"Staff - Edit Course Profile");
	set("edit_me" ,$cp_id);
	set("cp_active" ,"true");
	
	return render("staff/staff.cp.add.html.php");
}

function staff_cp_edit_post() {
	extract($_POST);
	$c = CourseProfile::LoadAndUpdate($_POST, $GLOBALS['db']);
	
	if(is_object($r) && get_class($r) == "PDOException") {
		trigger_error("Error in CourseProfile::LoadAndUpdate. Error " . $r->getMessage(), E_USER_ERROR);
	} else {
		flash("success", "Course Profile $name has been successfully edited");
		return redirect('/staff/course_profile/');
	}
}

/**
 * Batch Delete the Course Profile from the table
 **/
function staff_cp_batch_delete() {	
	$cps = $_POST['course_profiles'];
	$db = $GLOBALS['db'];

	while($cp = current($cps)) {
		// Deletes all CPs in a CASCADED manner
		$db->delete("course_profile", "idcourse_profile = :cip and staff_id = :sid", array(":cip" => key($cps), ":sid" => $_POST['staff_id']));
		
		next($cps);
	}
	
	return redirect('staff/course_profile/');
}

function staff_timetable_render() {
	layout('staff/layout.html.php');
	set("title" ,"Staff - Time Table");
	set("tt_active" ,"true");

    return render("staff/staff.timetable.html.php");
}

function staff_attendance_render() {
	layout('staff/layout.html.php');
	set("title" ,"Staff - Attendance");
	set("at_active" ,"true");

    return render("staff/staff.attendance.html.php");
}

function staff_cia_render() {
	layout('staff/layout.html.php');
	set("title" ,"Staff - CIA");
	set("cia_active" ,"true");

    return render("staff/staff.cia.html.php");
}


function staff_cp_create() {
	extract($_POST);

	// Load and save the Course Profile to the list
	$r = CourseProfile::LoadAndSave($_POST, $GLOBALS['db']);
	
	if(is_object($r) && get_class($r) == "PDOException") {
		trigger_error("Error in CourseProfile::LoadAndSave", E_USER_ERROR);
	} else {
		flash("success", "Course Profile $name has been successfully added");
		return redirect('/staff/course_profile/');
	}
}
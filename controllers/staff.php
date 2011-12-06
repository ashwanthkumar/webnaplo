<?php

/**
 *	Renders the Home page dashboard for the Staff members. Also acts as the generic staff route handler. 
 *
 *	@method GET
 *	@route /staff/home
 **/
function staff_home_render() {
	layout('staff/layout.html.php');
	set("title" ,"Staff Home");
	set("home_active" ,"true");

    return render("staff/staff.home.html.php");
}

/**
 *	Renders the Add Course Profile page to the logged in user. 
 *
 *	@method GET
 *	@route	/staff/course_profile/add
 **/
function staff_cp_add_render() {
	layout('staff/layout.html.php');
	set("title" ,"Staff - Add Course Profile");
	set("cp_active" ,"true");

    return render("staff/staff.cp.add.html.php");
}

/**
 *	Renders the view page of the course profie
 *
 *	@method GET
 *	@route	/staff/course_profile
 **/
function staff_cp_view_render() {
	layout('staff/layout.html.php');
	set("title" ,"Staff - Course Profile");
	set("cp_active" ,"true");

    return render("staff/staff.cp.view.html.php");
}

/**
 *	Deletes the Course profile of a particular staff member
 *
 *	@method	GET
 *	@route 	^/staff/course_profile/(\d+)/delete
 **/
function staff_cp_delete() {
	$cp_id = params(0);
	$db = $GLOBALS['db'];

	$user = get_user();
	$r = CourseProfile::DeleteByStaff($cp_id, $user->userid, $db);
	
	
	if(is_object($r) && get_class($r) == "PDOException" || $r === false) {
		halt("Error in Course Profile Delete", E_USER_ERROR);
	} else {
		if($r > 0) {
			flash("success", "Course Profile $name has been successfully deleted");
			return redirect('/staff/course_profile/');
		} else {
			flash("warning", "Course Profile $name was not found in the system or you do not have access to it");
			return redirect('/staff/course_profile/');
		}
	}
	
	return redirect("staff/course_profile/");
}

/**
 *	Renders the Edit page of the Course profile for a logged in staff member.
 *
 *	@method GET
 *	@route	^/staff/course_profile/(\d+)/edit
 **/
function staff_cp_edit() {
	$cp_id = params(0);
	layout('staff/layout.html.php');
	set("title" ,"Staff - Edit Course Profile");
	set("edit_me" ,$cp_id);
	set("cp_active" ,"true");
	
	return render("staff/staff.cp.add.html.php");
}

/**
 *	Handles the POST action from the Course Profile Edit page.
 *
 *	@method POST
 *	@route	/staff/course_profile/edit
 **/
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
 * Batch Delete the Course Profile from the table of Course Profile View 
 *
 *	@method POST
 *	@route /staff/course_profile/batch/delete
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

/**
 *	Create a course profile instance object. 
 *
 *	@method POST
 *	@route	/staff/course_profile/create
 **/
function staff_cp_create() {
	extract($_POST);

	// Load and save the Course Profile to the list
	$r = CourseProfile::LoadAndSave($_POST, $GLOBALS['db']);
	
	if(is_object($r) && get_class($r) == "PDOException") {
		halt("Error in CourseProfile::LoadAndSave", E_USER_ERROR);
	} else {
		flash("success", "Course Profile $name has been successfully added");
		return redirect('/staff/course_profile/');
	}
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


/**
 *	Shows the timetable selection window as a full page popup window
 *
 *	@method GET
 *	@route	/staff/timetable/popup
 **/
function staff_timetable_popup_render() {
	layout('staff/empty.layout.html.php');
	set('title', "Staff - Timetable Editor");
	
	return render('/staff/staff.timetable.popup.html.php');
}

/**
 *	Save the timetable of the current staff member from the Popup window
 *
 *	@method POST
 *	@route	/staff/timetable/save
 **/
function staff_timetable_save() {
	$user = get_user();
	$db = $GLOBALS['db'];
	
	$days = array(1 => "Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
	
	// first delete the current timetable for the staff
	Staff::clearTimetable($user->userid, $db);
	
	while($tt = current($_POST)) {
		// Add only if its not a free period
		if($tt > -1):
			/*
				Day 	- $day_hour[0]
				Hour 	- $day_hour[1]
			*/
			$day_hour = explode("_", (key($_POST)));
			
			$db->insert("timetable", array(
									"days_of_week" => $day_hour[0], 
									"hour_of_day" => $day_hour[1],
									"cp_id" => $tt));
		endif;
		
		next($_POST);
	}
	
	flash('success', "Your timetable has been successfully updated.");
	
	return redirect('staff/timetable/popup');
}

/**
 *	Render the View Profile page for the Staff members
 *
 *	@method	GET
 *	@route	/staff/profile/view
 **/
function staff_profile_render() {
	return render('staff/staff.profile.html.php');
}

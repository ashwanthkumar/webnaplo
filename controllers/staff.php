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
	} else if($r === false) {
		flash("error", "A Course Profile already exist for the Course. No new Course Profiles were created.");
		return redirect('/staff/course_profile/add/');
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
	Staff::SclearTimetable($user->userid, $db);
	
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
	layout('staff/layout.html.php');
	set('title', "Staff - View Profile");

	return render('/staff/staff.profile.html.php');
}

/**
 *	Add a student to a course profile. This method is implemented for AJAX calls.
 *
 *	@method	POST
 *	@route	^/staff/course_profile/(\d+)/ajax/addstudent
 **/
function staff_cp_student_add_ajax() {
	$cp_id = params(0);
	$student_id = $_POST['studentid'];
	
	$stud_list = explode(",", $student_id);
	
	$cnt_stud_list = count($stud_list);
	
	$course_profile = CourseProfile::load($cp_id, $GLOBALS['db']);
	$list_of_students_added = array();
	
	$r = $course_profile->addStudent($stud_list, $GLOBALS['db'], $list_of_students_added);
	
	// Return only if all the students were inserted
	if($r == $cnt_stud_list || $r > 0) return json($list_of_students_added);
	else return json("false");
}

/**
 *	Delete a student from a course profile. This method is implemented for AJAX calls.
 *
 *	@method	POST
 *	@route	^/staff/course_profile/(\d+)/ajax/delstudent
 **/
function staff_cp_student_del_ajax() {
	$cp_id = params(0);
	$student_id = $_POST['studentid'];
	
	$stud_list = explode(",", $student_id);
	
	$cnt_stud_list = count($stud_list);
	
	$course_profile = CourseProfile::load($cp_id, $GLOBALS['db']);
	$r = $course_profile->removeStudent($stud_list, $GLOBALS['db']);
	
	// Return only if all the students were inserted
	if($r == $cnt_stud_list) return json($stud_list);
	else return json("false");
}

/**
 *	Shows the attendace post window as a full page popup window
 *
 *	@method GET
 *	@route	^/staff/attendance/(\d+)/popup
 **/
function staff_attendance_popup_render() {
	// Get the Course Profile ID from the URL
	$course_profile_id = params(0);

	set('cpid', $course_profile_id);
	layout('staff/empty.layout.html.php');
	set('title', "Staff - Post Attendance");
	
	return render('/staff/staff.attendance.popup.html.php');
}

/**
 *	Saves the Attendance for a particular day for a given course profile
 *
 *	@method	POST
 *	@route 	/staff/attendance/save
 **/
function staff_attendance_save() {
	$db = $GLOBALS['db'];
	
	$hour_of_day = $_POST['hour_of_day'];
	
	$date_of_attendance = strtotime($_POST['date_selector']);
	$days_of_week = date('N	', $date_of_attendance);
	
	$course_profile = $_POST['course_profile'];
	
	$timetable_id = Attendance::getTimetableId($course_profile, $date_of_attendance, $hour_of_day, $days_of_week, $db);
	if($timetable_id < 0) {
		flash('error', 'There seems to be some technical error happened in the system. Please try again');
		return redirect('/staff/attendance/' . $course_profile . '/popup');
	} else {
		$students = $_POST['student'];
		// Clear any existing timetable values
		$cleared_status = Attendance::clearExistingAttendance($timetable_id, date('Y-m-d',$date_of_attendance), $db);
		while($student = current($students)) {
			$date_attendance = date('Y-m-d',$date_of_attendance); 	// date_attendance value
			$is_present = ($student == 'on') ? 1 : 0;				// is_present value
			$student_id = key($students);							// student_id value
			
			echo "Adding $student_id as " . (($is_present == 1) ? 'present' : 'absent') . " for the date $date_attendance";
			
			$attendance_insert_status = Attendance::insert($date_attendance,$is_present, $student_id, $timetable_id, $db);
			
			print_r($attendance_insert_status);
			
			next($students);
		}
	}
	
	flash('success', 'Your Attendance for ' . $_POST['date_selector'] . ' has been posted successfully');
	return redirect('/staff/attendance/' . $course_profile . '/popup');
}

/**
 *	Returns the Change Day Order and used for AJAX requests
 *
 *	@method	GET
 *	@route	/staff/changeorder/ajax
 **/
function staff_changeorder_ajax() {
	$db = $GLOBALS['db'];
	
	$change = Attendance::getChangeOrder($db);
	
	return json($change);
}

/**
 *	Renders the Staff Mark posting page for a particular course profile
 *
 *	@method	GET
 *	@route	^/staff/attendance/(\d+)/popup/(.*)
 **/
function staff_mark_popup_render() {
	// Get the Course Profile ID from the URL
	$course_profile_id = params(0);

	set('cpid', $course_profile_id);
	layout('staff/empty.layout.html.php');
	set('title', "Staff - Post Marks");
	
	return render("/staff/staff.cia.popup.html.php");
}

/**
 *	Saves the CIA Marks to the datastore from the POPUP window
 *
 *	@method	POST
 *	@route	/staff/ciamark/save
 **/
function staff_cia_save() {
	$cp_id = $_POST['course_profile'];
	$students = $_POST['student'];
	
	$db = $GLOBALS['db'];
	
	switch($_POST['cia_type']) {
		case "cia_1":
			while($student = current($students)) {
				$db->update("cia_marks", array("mark_1" => $student) ,"student_id = :sid and cp_id = :cpid", array(":sid" => key($students), ":cpid" => $cp_id));
				next($students);
			}
			flash('success', 'All the student marks for I CIA have been updated.');
			break;
		case "cia_2":
			while($student = current($students)) {
				$db->update("cia_marks", array("mark_2" => $student) ,"student_id = :sid and cp_id = :cpid", array(":sid" => key($students), ":cpid" => $cp_id));
				next($students);
			}
			flash('success', 'All the student marks for II CIA have been updated.');
			break;
		case "cia_3":
			while($student = current($students)) {
				$db->update("cia_marks", array("mark_3" => $student) ,"student_id = :sid and cp_id = :cpid", array(":sid" => key($students), ":cpid" => $cp_id));
				next($students);
			}
			flash('success', 'All the student marks for III CIA have been updated.');
			break;
		case "assignment":
			while($student = current($students)) {
				$db->update("cia_marks", array("assignment" => $student) ,"student_id = :sid and cp_id = :cpid", array(":sid" => key($students), ":cpid" => $cp_id));
				next($students);
			}
			flash('success', 'All the students\' assignment marks have been updated');
			break;
		default:
			flash('error', 'Invalid Mark Scheme selected');
			break;
	}
	
	return redirect("staff/marks/" . $cp_id . "/popup");
}

/**
 *	Return a JSON representation of the CIA data
 *
 *	@method	POST
 *	@route	/staff/ciamarks/load/ajax
 **/
function staff_cia_load_ajax() {
	$cp_id = $_POST['cpid'];
	$mark = $_POST['mark_type'];
	
	$db = $GLOBALS['db'];
	
	$markdata['status'] = false;
	$markdata['marks'] = array();
	$students = $db->select("cia_marks", "cp_id = :cpid", array(":cpid" => $cp_id));
	
	switch($mark) {
		case "cia_1":
			// Get all the students cia_1 mark under $cp_id
			foreach($students as $student) {
				$stud_id = $student['student_id'];
				$markdata['marks'][$stud_id] = $student['mark_1'];
			}
			
			$markdata['status'] = true;
			return json($markdata);
			break;
		case "cia_2":
			// Get all the students cia_2 mark under $cp_id
			foreach($students as $student) {
				$stud_id = $student['student_id'];
				$markdata['marks'][$stud_id] = $student['mark_2'];
			}
			
			$markdata['status'] = true;
			return json($markdata);
			break;
		case "cia_3":
			// Get all the students cia_3 mark under $cp_id
			foreach($students as $student) {
				$stud_id = $student['student_id'];
				$markdata['marks'][$stud_id] = $student['mark_3'];
			}
			
			$markdata['status'] = true;
			return json($markdata);
			break;
		case "assignment":
			// Get all the students assignment mark under $cp_id
			foreach($students as $student) {
				$stud_id = $student['student_id'];
				$markdata['marks'][$stud_id] = $student['assignment'];
			}
			
			$markdata['status'] = true;
			return json($markdata);
			break;
		default:
			$markdata['status'] = false;
			$markdata['error'] = "Invalid Mark type provided";
			break;
	}
	
	return json($markdata);
}

/**
 *	Disable Student Confirmation for the given course profile
 *
 *	@method	POST
 *	@route	/staff/cia/enable_confirmation/disable
 **/
function staff_enable_student_confirmation_disable_ajax() {
	$db = $GLOBALS['db'];
	
	$cp_id = $_POST['cp_id'];
	
	$cp = CourseProfile::load($cp_id, $db);
	$cp->enable_confirm = 0;
	$update_status = $cp->update($db);
	
	if(is_object($update_status) && get_class($update_status) == "PDOException") {
		return json(array("status" => false, "error" => $update_status->getMessage()));
	}
	
	return json(array("status" => true));
}

/**
 *	Enable Student Confirmation for the given course profile
 *
 *	@method	POST
 *	@route	^/staff/cia/enable_confirmation/enable
 **/
function staff_enable_student_confirmation_enable_ajax() {
	$db = $GLOBALS['db'];
	
	$cp_id = $_POST['cp_id'];
	
	$cp = CourseProfile::load($cp_id, $db);
	$cp->enable_confirm = 1;
	$update_status = $cp->update($db);
	
	if(is_object($update_status) && get_class($update_status) == "PDOException") {
		return json(array("status" => false, "error" => $update_status->getMessage()));
	}
	
	return json(array("status" => true));
}

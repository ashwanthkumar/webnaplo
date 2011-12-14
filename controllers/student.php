<?php

/**
 *	Render the Home page of the student
 *
 *	@method	GET
 *	@route	/student/home
 **/
function student_home_render() {
	layout('student/layout.html.php');
	set("title" ,"Student Home");
	set("home_active" ,"true");

    return render("student/stud.html.php");
}

/**
 *	Render the Student's Profile Page
 *
 *	@method	GET
 *	@route	/student/profile/**
 **/
function student_profile_render() {
	layout('student/layout.html.php');
	set("title" ,"Edit Profile");
	set("view_active" ,"true");
	
    return render("student/student.profile.html.php");
}

/**
 *	Updates the student profile information
 *
 *	@method	POST
 *	@route	/student/profile/update
 **/
function student_profile_post() {
	extract($_POST);
	
	// Update the Student
	$r = Student::LoadAndUpdate($_POST, $GLOBALS['db']);
	if(is_object($r) && get_class($r) == "PDOException") halt($r->getMessage());
	else {
		flash('success', "Profile successfully updated");
		return redirect('student/profile');
	}
}

/**
 *	Render the page where the students can view their CIA marks
 *
 *	@method	GET
 *	@route	/student/cia/**
 **/
function student_cia_render() {
	layout('student/layout.html.php');
	set("title" ,"Student CIA Marks");
	set("view_active" ,"true");
	
	return render("student/student.cia.html.php");
}

/**
 *	Render the Attendance view page for the students
 *
 *	@method	GET
 *	@route	/student/attendance/**
 **/
function student_attendance_render() {
	layout('student/layout.html.php');
	set("title" ,"Student Attendance");
	set("view_active" ,"true");
	
	return render("student/student.attendance.html.php");
}

/**
 *	Render the calendar of the semester for all students. It should actually render a PDF file, which is to be current added. 
 *
 *	@method	GET
 *	@route	/student/calendar/**
 **/
function student_calendar_render() {
	layout('student/layout.html.php');
	set("title" ,"Student Calendar");
	set("calendar_active" ,"true");
	
	return render("student/student.calendar.html.php");
}

/**
 *	Render the Timetable page for the students
 *	
 *	@method	GET
 *	@route	/student/timetable/**
 **/
function student_timetable_render() {
	layout('student/layout.html.php');
	set("title" ,"Student Timetable");
	set("timetable_active" ,"true");
	
	return render("student/student.timetable.html.php");
}

/**
 *	Render the feedback page for the student
 *
 *	@method	GET
 *	@route	/student/feedback/**
 **/
function student_feedback_render() {
	layout('student/layout.html.php');
	set("title" ,"Student Feedback");
	set("feedback_active" ,"true");
	
	return render("student/student.feedback.html.php");
}

/**
 *	Confirm the Marks by the students once they are enabled by the respective staff memebers.
 *
 *	@method	GET
 *	@route	^/student/cia/(\d+)/confirm
 **/
function student_marks_confirm() {
	$db = $GLOBALS['db'];
	$cp_id = params(0);
	
	$user = get_user();
	$student = Student::load($user->userid, $db);
	
	$confirm_status = $student->confirmInternals($cp_id, $db);
	
	if(!$confirm_status) flash('error', "There has been some technical problem. Please try again. ");
	else flash('success', "You have successfully confirmed the internals for the course");
	
	return redirect("/student/cia/view");
	// return h("$cp_id");
}

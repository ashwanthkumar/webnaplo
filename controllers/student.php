<?php

function student_home_render() {
	layout('student/layout.html.php');
	set("title" ,"Student Home");
	set("home_active" ,"true");

    return render("student/stud.html.php");
}

function student_profile_render() {
	layout('student/layout.html.php');
	set("title" ,"Edit Profile");
	set("view_active" ,"true");
	
    return render("student/student.profile.html.php");
}

function student_profile_post() {
	extract($_POST);
	
	print_r($_POST);
	return h("TODO");
}

function student_cia_render() {
	layout('student/layout.html.php');
	set("title" ,"Student CIA Marks");
	set("view_active" ,"true");
	
	return render("student/student.cia.html.php");
}

function student_attendance_render() {
	layout('student/layout.html.php');
	set("title" ,"Student Attendance");
	set("view_active" ,"true");
	
	return render("student/student.attendance.html.php");
}

function student_calendar_render() {
	layout('student/layout.html.php');
	set("title" ,"Student Calendar");
	set("calendar_active" ,"true");
	
	return render("student/student.calendar.html.php");
}

function student_timetable_render() {
	layout('student/layout.html.php');
	set("title" ,"Student Timetable");
	set("timetable_active" ,"true");
	
	return render("student/student.timetable.html.php");
}

function student_feedback_render() {
	layout('student/layout.html.php');
	set("title" ,"Student Feedback");
	set("feedback_active" ,"true");
	
	return render("student/student.feedback.html.php");
}


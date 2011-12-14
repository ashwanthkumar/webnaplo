<?php
	
	/**
	 *	Required or Mandatory file in the ./i18n/locale_<lang_code>.php directory where the actual locale information is added to the list
	 *
	 *	@i18n	en
	 *	@author Ashwanth Kumar <ashwanth@ashwanthkumar.in>
	 *	@date 12/11/2011
	 **/
	 
	/**
	 * English Language Script
	 **/
	$_LOCALE = array(
		// Generic Strings
		"TAMIL" => "TAMIL", 
		"WEBNAPLO" => "WebNaplo ", 
		
		// Admin Page Strings
		"ADMIN" => "Admin",
		"HOME" => "Home",
		"STAFF" => "Staff",
		"STUDENT" => "Student",
		"LIST" => "List",
		"DELETE" => "Delete",
		"COURSE" => "Course",
		"DEPARTMENT" => "Department",
		"LOCK" => "Lock",
		"UNLOCK" => "Unlock", 
		"EDIT" => "Edit",
		"BLOCK" => "Block ",
		"UNBLOCK" => "UnBlock",
		"USERS" => "Users",
		"BLOCK_UNBLOCK_USERS" => "Block/Unblock Users",
		"LOGOUT" => "Logout",
		"SETTINGS" => "Settings ",
		"ADVANCED_SETTINGS" => "Advanced Settings",
		"SASTRA_UNIVERSITY" => "Sponsored by SASTRA University",
		"CHOOSE_ACTION" => "Choose Action",
		"APPLY_SELECTED" => "Apply Selected",
		"STAFF_LIST" => "Staff List",
		"COURSE_LIST" => "Course List",
		"PROGRAMME_LIST" => "Programme List",
		"PROGRAMME" => "Programme ",
		"NEWS_UPDATES" => "News and Updates ",
		"CAMPUS_STATUS" => "Campus Status",
		"DEPARTMENT" => "Department",
		"SYSTEM_STATUS" => "System Status ",
		"VERSION" => "Version ",
		"RELEASE" => "Release",
		"BUILD_DATE" => "Build Date",
		"STATUS" => "Status",
		"AND" => " and ",
		"ADVANCED_IMPORT_SETTINGS" => "Import",
		"DELETE_PROGRAMME" => "Delete Programme",
		"DELETE_COURSE" => "Delete Course",
		"DELETE_DEPARMENT"=> "Delete Department",
		"DELETE_SECTION" => "Delete Section",
		"DELETE_STAFF" => "Delete Staff",
		"DELETE_STUDENT" => "Delete Student",
		"CHANGEDAYORDER_TITLE" => "Change Day Order",
		"DELETE_SELECTED" => "Delete Selected",
		"ADVANCED_CHANGE_DAY_ORDER" => "Change Day Orders",	
		
		// Dataentry
		"ADD" => "Add",
		"ADD_PROGRAMME" => "Add Programme",
		"ADD_COURSE" =>"Add Course",
		"COURSE_CODE" => "Course Code",
		"COURSE_NAME" =>"Course Name",
		"CREDITS" => "Credits",
		"PROGRAMME_NAME" => "Programme Name",
		"RESET" => "Reset",
		"ADD_DEPARMENT"=>"Add Department",
		"DEPARTMENT_NAME" => "Deparment Name",
		"NAME" => "Name",
		"ADD_STUDENT"=>"Add Student",
		"REGISTRAION_NO" => "Registraion No",
		"SECION_NAME" => "Secion Name",
		"YEAR"=>"Year",
		"ADD_STAFF"=> "Add Staff",
		"DESIGNATION" => "Designation",
		"STAFF_ID" => "Staff Id",
		"EMAIL_ID" => "Email Id",
		"MOBILE_NO"=>"Mobile No",
		"ADDRESS" => "Address",
		"ADD_SECTION" => "Add Section",
		"QUICK_STATS" => "Quick Stats",
		"CHANGE_PASSWORD" => "Change Password",
		"NEW_PASSWORD" => "New Password",
		"UPDATE_PASSWORD" => "Update Password",

		// Staff Module 
		"COURSE_PROFILE" => "Course Profile",
		"ATTENDANCE" => "Attendance",
		"PENDING_ATTENDENCE" =>"Pending Attendence",
		"CIA" =>"CIA",
		"VIEW" =>"View",
		"PROFILE"=> "Profile",
		"STAFF_PROFILE" => "Saff Profile",
		"CUMULATIVE_REPORT" => "Cumulative Report",
		"MARK_TYPE" => "Mark Type",
		"TOOLS" => "Tools",
		"POST_MARKS" => "Post Marks",
		"ASSIGNMENT" => "Assignment",
		"STUDENT_CONFIRMATION" => "Student Confirmation",
		
		// Student Page
		"FEEDBACK" => "Feedback",
		"CALENDAR" => "Calender",
		"TIMETABLE" => "Timetable",
		"MONDAY" => "Monday",
		"TUESDAY" => "Tuesday",
		"WEDNESDAY" => "Wednesday",
		"THURSDAY" => "Thursday",
		"FRIDAY" => "Friday",
		"TIMESLOTS" => "Time Slots",
		"DAYS" => "Days", 
		"STUDENT_CIA_MARKS" => "Student CIA Marks",

		// Login Page Strings
		"LOGIN" => "Login",
		"USERNAME" => "Username",
		"PASSWORD" => "Password",
		"LOGIN_PAGE" => "Login Page ",
		"WELCOME_TO_WEBNAPLO" => "Welcome to WebNaplo",
		"ENTER_USERNAME" => "enter your username", 
		"ENTER_PASSWORD" => "enter your password", 
	);
	

	// Add the locale information to the system
	locale('en', $_LOCALE);
	
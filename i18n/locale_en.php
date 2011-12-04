<?php
	
	/**
	 *	Required or Mandatory file in the ./i18n/<lang_code>/ directory where the actual locale information is added to the list
	 *
	 *	@i18n	en
	 *	@author Team Webnaplo
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
	
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
	);
	

	// Add the locale information to the system
	locale('en', $_LOCALE);
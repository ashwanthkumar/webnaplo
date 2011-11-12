<?php
	
	/**
	 *	Required or Mandatory file in the ./i18n/<lang_code>/ directory where the actual locale information is added to the list
	 *
	 *	@i18n	ta
	 *	@author Team Webnaplo
	 *	@date 12/11/2011
	 **/
	 
	/**
	 * Tamil Language Script
	 **/
	$_LOCALE = array(
		"TAMIL" => "தமிழ் ", 
		"ADMIN" => "நிர்வாகி", 
		"HOME" => "முதற் பக்கம்", 
		"STAFF" => "பணியாளர்",
		"STUDENT" => "மாணவர்கள்",
		"LIST" => "பட்டியல்",
		"DELETE" => "எடுத்துவிடு ",
		"COURSE" => "படிப்புப் பிரிவு ",
		"DEPARTMENT" => "துறை ",
		"LOCK" => "பூட்டு ",
		"UNLOCK" => "திற ",
		"EDIT" => "தொகு ",
		"BLOCK" => "தடை செய்",
		"UNBLOCK" => "தடை நீக்கு ",
		"USERS" => "உபயோகிப்பவர்கலை ", 
		"BLOCK_UNBLOCK_USERS" => "உபயோகிப்பவர்கலை தடை செய் / நீக்கு ",
		"LOGOUT" => "மூடு ",
		"SETTINGS" => "அமைப்பு ",
		"ADVANCED_SETTINGS" => "முற்றிய அமைப்பு ",
		"SASTRA_UNIVERSITY" => "சாஸ்த்ரா பல்கலைக்கழகம் ",
		"CHOOSE_ACTION" => "தேர்வு செய் ",
		"APPLY_SELECTED" => " பயன்படுத்து ",
		"STAFF_LIST" => "பணியாளர் பட்டியல்",
		"COURSE_LIST" => "படிப்புப் பிரிவு பட்டியல்",
	);
	

	// Add the locale information to the system
	locale('ta', $_LOCALE);

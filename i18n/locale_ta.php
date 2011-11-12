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
		// Generic Strings
		"TAMIL" => "தமிழ் ", 
		"WEBNAPLO" => "வேப்னாப்லோ ", 
		
		// Admin Page Strings
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
		"PROGRAMME_LIST" => "Programme List",
		"PROGRAMME" => "Programme ",
		"NEWS_UPDATES" => "செய்தி மட்ற்றும் புதுப்பித்தல் ",
		"CAMPUS_STATUS" => "வளாகம் நிலமை  ",
		"DEPARTMENT" => "துறை   ",
		"SYSTEM_STATUS" => "சிஸ்டம்  நிலமை ",
		"VERSION" => "பதிப்பு  ",
		"RELEASE" => "வெளியீடு பெயர்",
		"BUILD_DATE" => "வெளியீடு நாள்",
		"STATUS" => "நிலமை",
		"AND" => "மற்றும் ",
		
		// Login Page Strings
		"LOGIN" => "நுழை ",
		"USERNAME" => "பயனீட்டாளர் பெயர்",
		"PASSWORD" => "மறைச் சொல்",
		"LOGIN_PAGE" => "நுழைவு வாயில் ",
		"WELCOME_TO_WEBNAPLO" => "வேப்னாப்லோகு நல்வரவு",
		"ENTER_USERNAME" => "பயனீட்டாளர் பெயர் எழுது  ",
		"ENTER_PASSWORD" => "மறைச் சொல் எழுது  ",
	);
	

	// Add the locale information to the system
	locale('ta', $_LOCALE);

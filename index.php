<?php

/**
 *	Central controller for the entire webnaplo application 
 *
 *	@author Team WebnNaplo
 *	@date 06/11/2011 - Sunday
 **/

// We're using the Limanade Micro PHP Framework
require_once("lib/limonade/limonade.php");

// Start the session for the application right here
session_start();

/**
 *	Setting the Configuration for the system
 **/
function configure() {
	option('env', ENV_DEVELOPMENT);
	// Setting the locale settings
	option('default_locale', 'en');	// Default locale is always english
	
	// Setting the default locale if its not found
	if(isset($_SESSION['locale'])) 
		option('locale', $_SESSION['locale']);
	else 
		option('locale', option('default_locale'));
	
	option('limonade_public_dir', file_path(dirname(__FILE__), 'lib', 'limonade', 'public'));
	option('limonade_views_dir', file_path(dirname(__FILE__), 'lib', 'limonade', 'views'));
	option('error_views_dir',    option('limonade_views_dir'));
	option('controllers_dir', file_path(dirname(__FILE__), 'controllers'));
	option('reports_dir', file_path(dirname(__FILE__), 'export'));
	// Directories that contain all the translations
	option('locale_dir', file_path(dirname(__FILE__), 'i18n'));
	// Root directory of all the library
	option('lib_dir', file_path(dirname(__FILE__), 'lib'));
	
	option('gzip', true);
	
	// System Settings 
	option('SYSTEM_VERSION', '1.1');
	option('SYSTEM_NAME', 'WebNaplo');
	
	// Include all the models to the system
	require_once_dir(file_path(dirname(__FILE__), 'models'));
	require_once_dir(file_path(dirname(__FILE__), 'lib'));
	require_once_dir(file_path(option('lib_dir') , 'wkhtmltopdf'));
	require_once_dir(file_path(option('lib_dir'), 'phpexcel'));
	require_once_dir(file_path(option('locale_dir')));

	// Include the configuration file
	include("config.php");
	
	$db = new db("mysql:host=$db_host;port=$db_port;dbname=$db_name", "$db_user", "$db_pass");
	$db->setErrorCallbackFunction("showError", "text");
	
	$GLOBALS['db'] = $db; 
	
}

/**
 * Utility function that returns the curent instance of the user using the system
 *	
 *	@return Current User Instance
 *	@since 1.1
 **/
function get_user() {
	if(isset($_SESSION['user'])) return User::load(get_object_vars($_SESSION['user']));
	
	return new User;
}

/**
 * 	Checks the $_LOCALE variable to fetch the corresponding $key value
 *
 *	@return Matching translated text
 *	@since 1.1
 **/
function get_text($key, $lang = null) {
	$locale = option('locale');
	$_LOCALE = option('_LOCALE');
	
	if($lang == null) :
		if(array_key_exists($key, $_LOCALE[$locale])) {
			// Current Language has the requested key
			return $_LOCALE[$locale][$key];
		} else {
			// During develokpment let the developer know that the request key is not available
			if(option('env') === ENV_DEVELOPMENT)
				return "i18n:[$key not found]";
			else {
				// Request the key from the default locale (which god willingly should contain all keys used)
				$default_locale = option('default_locale');
				return $_LOCALE[$default_locale][$key]; 
			}
		}
	else :
		return $_LOCALE[$lang][$key];
	endif;
}

/**
 * 	Function that adds locale strings to the system
 *
 *	@param $locale String to load into the system
 *	@since 1.1
 **/
function locale($iso_code, $locale) {
	$_LOCALE = option('_LOCALE');
	$_LOCALE[$iso_code] = $locale;

	option('_LOCALE', $_LOCALE);
}


/**
 *	Callback function of PDO Library
 **/
function showError($message) {
	// header("Content-type: application/json");
	// return json(array("status" => false, "message" => $message));
	halt(SERVER_ERROR, $message);
}

/**
 *	Hook that is to be executed before processing any request
 **/
function before($route) {
	// header("X-LIM-route-function: ".$route['callback']);
	// layout('layout.html.php');
	$route_pattern = $route['pattern'];

	// Callback functions for which user session check is to be skipped
	$func_calls_no_user_session = array('user_login', 'user_login_authenticate', 'user_logout', 'add_student_proxy', 'dataentry_report_list', 'user_change_locale', 'user_javascript_i18n_render', 'webnaplo_home', 'staff_creport_pdf_view');
	if(!in_array($route['callback'], $func_calls_no_user_session)) {
		// redirect('/');
		if(!isset($_SESSION['user'])) {
			flash("error", "You need to login to view the requested resource");
			redirect('/user/login');
			// redirect(htmlspecialchars_decode(url_for('/user/login/', array("redirect" => $route['pattern'])), ENT_NOQUOTES));
		} else {
			// Get the current User instance using the application
			$user = get_user();
			
			$access = -1;
			
			// Caculating the Access level of the route based on the callback function
			if(preg_match('/^admin_*/', $route['callback'], $match) > 0) {
				// Admin Access Route to be enabled nly by the admin users
				$access = 0;
			} else if(preg_match('/^dataentry_*/', $route['callback'], $match) > 0) {
				$access = 1;
			} else if(preg_match('/^staff_*/', $route['callback'], $match) > 0){
				$access = 2;
			} else if(preg_match('/^student_*/', $route['callback'], $match) > 0) {
				$access = 3;
			} else {
				$access = -1;
			}
			
			// Now decide if the user has the access to access the requested resource
			if ($route['callback'] == 'webnaplo_home') {
				// Its either notfound or the default home page
			} else if($user->accessLevel > $access || $user->accessLevel == -1 && $route['callback'] != 'webnaplo_home') {
				halt(HTTP_FORBIDDEN, "Sorry hacker, your request cannot be handled. ");
			}
		}
	}
}
/**
 *	Dispatch routes follow
 *	DO NOT EDIT BELOW THIS LINE UNTIL YOU KNOW WHAT YOU ARE DOING
 **/

// -------------------------------------------
// Central Dispatch for Dataentry module
// -------------------------------------------
dispatch_get('/dataentry/home/', 'dataentry_home');
dispatch_post('/dataentry/changepass/', 'dataentry_changepass');

// -------------------------------------------
// Add Dataentry controllers
// -------------------------------------------
dispatch_get('/dataentry/course/add/', 'dataentry_add_course_render');
dispatch_post('/dataentry/course/add/', 'dataentry_add_course_post');

dispatch_get('/dataentry/department/add/', 'dataentry_add_department_render');
dispatch_post('/dataentry/department/add/', 'dataentry_add_department_post');

dispatch_get('/dataentry/programme/add/', 'dataentry_add_programme_render');
dispatch_post('/dataentry/programme/add/', 'dataentry_add_programme_post');

dispatch_get('/dataentry/section/add/', 'dataentry_add_section_render');
dispatch_post('/dataentry/section/add/', 'dataentry_add_section_post');

dispatch_get('/dataentry/staff/add/', 'dataentry_add_staff_render');
dispatch_post('/dataentry/staff/add/', 'dataentry_add_staff_post');

dispatch_get('/dataentry/student/add/proxy', 'dataentry_add_student_proxy');
dispatch_get('/dataentry/student/add/', 'dataentry_add_student_render');
dispatch_post('/dataentry/student/add/', 'dataentry_add_student_post');

// ------------------------------------------
// List Dataentry controllers
// ------------------------------------------
dispatch_get('/dataentry/programme/list/', 'dataentry_list_programme_render');
dispatch_post('/dataentry/programme/list/', 'dataentry_list_programme_post');

dispatch_get('/dataentry/section/list/', 'dataentry_list_section_render');
dispatch_post('/dataentry/section/list/', 'dataentry_list_section_post');

dispatch_get('/dataentry/staff/list/', 'dataentry_list_staff_render');
dispatch_post('/dataentry/staff/list/', 'dataentry_list_staff_post');

dispatch_get('/dataentry/course/list/', 'dataentry_list_course_render');
dispatch_post('/dataentry/course/list/', 'dataentry_list_course_post');


dispatch_get('/dataentry/export/list/:type', 'dataentry_export_list');
dispatch_get('/dataentry/report/list/:type', 'dataentry_report_list');

dispatch_post('/dataentry/**', 'dataentry_home');

// ------------------------------------------
// Student View Controllers
// ------------------------------------------

dispatch_post('/student/profile/update', 'student_profile_post');
dispatch_get('/student/profile/**', 'student_profile_render');

dispatch_get('^/student/cia/(\d+)/confirm', 'student_marks_confirm');
dispatch_get('/student/cia/**', 'student_cia_render');

dispatch_get('/student/attendance/**', 'student_attendance_render');
dispatch_get('/student/calendar/**', 'student_calendar_render');
dispatch_get('/student/timetable/**', 'student_timetable_render');
dispatch_get('/student/feedback/**', 'student_feedback_render');

// Matches all other fields in student controller
dispatch_get('/student/home', 'student_home_render');
dispatch_get('/student/**', 'student_home_render');


// ------------------------------------------
// Staff View Controllers
// ------------------------------------------
dispatch_get('/staff/profile/view', 'staff_profile_render');
dispatch_post('/staff/profile/save', 'staff_profile_post');

dispatch_get('staff/cumulative_report/view', 'staff_creport_render');

dispatch_get('/staff/course_profile', 'staff_cp_view_render');
dispatch_get('/staff/course_profile/add', 'staff_cp_add_render');
dispatch_post('/staff/course_profile/create', 'staff_cp_create');

dispatch_get('/staff/cumulative_report/download/:cpid', 'staff_creport_pdf_download');
dispatch_get('/staff/cumulative_report/view/:cpid', 'staff_creport_pdf_view');

dispatch_get('/staff/timetable/', 'staff_timetable_render');
dispatch_get('/staff/timetable/popup', 'staff_timetable_popup_render');
dispatch_post('/staff/timetable/save', 'staff_timetable_save');

dispatch_get('/staff/cia/', 'staff_cia_render');
dispatch_post('/staff/cia/enable_confirmation/disable', 'staff_enable_student_confirmation_disable_ajax');
dispatch_post('/staff/cia/enable_confirmation/enable', 'staff_enable_student_confirmation_enable_ajax');

dispatch_get('^/staff/marks/(\d+)/popup', 'staff_mark_popup_render');
dispatch_post('/staff/ciamark/save', 'staff_cia_save');
dispatch_post('/staff/ciamarks/load/ajax', 'staff_cia_load_ajax');

dispatch_get('^/staff/course_profile/(\d+)/delete', 'staff_cp_delete');
dispatch_get('^/staff/course_profile/(\d+)/edit', 'staff_cp_edit');
dispatch_post('/staff/course_profile/edit', 'staff_cp_edit_post');
dispatch_post('^/staff/course_profile/(\d+)/ajax/addstudent', 'staff_cp_student_add_ajax');
dispatch_post('^/staff/course_profile/(\d+)/ajax/delstudent', 'staff_cp_student_del_ajax');

dispatch_get('/staff/attendance/', 'staff_attendance_render');
dispatch_get('^/staff/attendance/(\d+)/popup', 'staff_attendance_popup_render');
dispatch_post('/staff/attendance/save', 'staff_attendance_save');

dispatch_get('/staff/changeorder/ajax', 'staff_changeorder_ajax');

dispatch_post('/staff/course_profile/batch/delete', 'staff_cp_batch_delete');
// Matches all other fields in staff controller
dispatch_get('/staff/home', 'staff_home_render');
dispatch_get('/staff/**', 'staff_home_render');

// ------------------------------------------
// Admin functions
// ------------------------------------------
dispatch_get('/admin/advanced/', 'admin_advanced_render');
dispatch_get('/admin/advanced/import', 'admin_import_render');

dispatch_get('/admin/advanced/changedayorder', 'admin_advanced_changedayorder');
dispatch_get('^/admin/changedayorder/(\d+)/delete', 'admin_advanced_changedayorder_delete');
dispatch_post('/admin/changedayorder/add', 'admin_advanced_changedayorder_add');
dispatch_post('/admin/changedayorder/delete', 'admin_advanced_changedayorder_batch_delete');

// Import File Handlers
dispatch_post('/admin/advanced/import/upload/student', 'admin_import_students');
dispatch_post('/admin/advanced/import/upload/staff', 'admin_import_staffs');
dispatch_post('/admin/advanced/import/upload/programme', 'admin_import_programmes');
dispatch_post('/admin/advanced/import/upload/course', 'admin_import_courses');
dispatch_post('/admin/advanced/import/upload/dept', 'admin_import_dept');

// Reset Passwords
dispatch_post('/admin/user/reset/', 'admin_user_reset_password');
dispatch_post('/admin/user/reset/staff/all', 'admin_staff_all_reset_password');
dispatch_post('/admin/user/reset/student/all', 'admin_student_all_reset_password');

// Change Admin Password
dispatch_post('/admin/user/admin/update/password', 'admin_update_admin_password');
// Change Dataentry Password
dispatch_post('/admin/user/dataentry/update/password', 'admin_update_dataentry_password');

// Lock and Unlock page
dispatch_get('/admin/lock/', 'admin_lock_render');
// Lock and Unlock Staff
dispatch_get('^/admin/lock_unlock/(\d+)/(\d+)/lock', 'admin_lock_entity');
dispatch_get('^/admin/lock_unlock/(\d+)/(\d+)/unlock', 'admin_unlock_entity');

// Block and UnBlock Page
dispatch_get('/admin/block_unblock/', 'admin_block_unblock_render');

// News Page
dispatch_get('/admin/news/', 'admin_news_render');
dispatch_get('/admin/news/add', 'admin_news_add_render');
dispatch_post('/admin/news/add', 'admin_news_add_post');
dispatch_post('/admin/news/batch/delete', 'admin_news_batch_delete_post');
dispatch_get('^/admin/news/(\d+)/delete', 'admin_news_delete');

// Staff Blocking and Unblocking process
dispatch_post('/admin/staff/block', 'admin_staff_block_post');
dispatch_get('^/admin/staff/(\d+)/block', 'admin_staff_block');
dispatch_get('^/admin/staff/(\d+)/unblock', 'admin_staff_unblock');

// Student Blocking and Unblocking process
dispatch_post('/admin/student/block', 'admin_student_block_post');
dispatch_get('^/admin/student/(\d+)/block', 'admin_student_block');
dispatch_get('^/admin/student/(\d+)/unblock', 'admin_student_unblock');

// -------------------------------------------
// Delete Admin controllers
// -------------------------------------------
dispatch_get('/admin/course/delete/', 'admin_delete_course_render');
dispatch_post('/admin/course/delete/', 'admin_delete_course_post');

dispatch_get('/admin/student/delete/', 'admin_delete_student_render');
dispatch_post('/admin/student/delete/', 'admin_delete_student_post');

dispatch_get('/admin/staff/delete/', 'admin_delete_staff_render');
dispatch_post('/admin/staff/delete/', 'admin_delete_staff_post');

dispatch_get('/admin/programme/delete/', 'admin_delete_programme_render');
dispatch_post('/admin/programme/delete/', 'admin_delete_programme_post');

dispatch_get('/admin/department/delete/', 'admin_delete_department_render');
dispatch_post('/admin/department/delete/', 'admin_delete_department_post');

// ------------------------------------------
// Edit Admin controllers
// ------------------------------------------
dispatch_get('^/admin/course/(\d+)/edit', 'admin_edit_course_render');
dispatch_get('^/admin/course/edit', 'admin_edit_course_render');
dispatch_post('^/admin/course/(\d+)/edit', 'admin_edit_course_post');

dispatch_get('^/admin/department/(\d+)/edit', 'admin_edit_department_render');
dispatch_post('^/admin/department/(\d+)/edit', 'admin_edit_department_post');

dispatch_get('^/admin/programme/(\d+)/edit', 'admin_edit_programme_render');
dispatch_post('^/admin/programme/(\d+)/edit', 'admin_edit_programme_post');

dispatch_get('^/admin/section/(\d+)/edit', 'admin_edit_section_render');
dispatch_post('^/admin/section/(\d+)/edit', 'admin_edit_section_post');

dispatch_get('^/admin/staff/(\d+)/edit', 'admin_edit_staff_render');
dispatch_post('^/admin/staff/(\d+)/edit', 'admin_edit_staff_post');

dispatch_get('^/admin/student/(\d+)/edit', 'admin_edit_student_render');
dispatch_post('^/admin/student/(\d+)/edit', 'admin_edit_student_post');

// ------------------------------------------
// List Admin controllers
// ------------------------------------------
dispatch_get('/admin/programme/list/', 'admin_list_programme_render');
dispatch_post('/admin/programme/list/', 'admin_list_programme_post');

dispatch_get('/admin/section/list/', 'admin_list_section_render');
dispatch_post('/admin/section/list/', 'admin_list_section_post');

dispatch_get('/admin/staff/list/', 'admin_list_staff_render');
dispatch_post('/admin/staff/list/', 'admin_list_staff_post');

dispatch_get('/admin/course/list/', 'admin_list_course_render');
dispatch_post('/admin/course/list/', 'admin_list_course_post');

// Export Reports
dispatch_get('/admin/export/list/:type', 'dataentry_export_list');
dispatch_get('/admin/report/list/:type', 'dataentry_report_list');

dispatch_get('/admin/js/', 'admin_js_render');
dispatch_get('/admin/home', 'admin_home_render');

// ------------------------------------------
// Main or Other functions
// ------------------------------------------
dispatch_get('/user/js/i18n', 'user_javascript_i18n_render');

dispatch_get('/user/locale/:lang', 'user_change_locale');
dispatch_get('/user/login', 'user_login');
dispatch_post('/user/login', 'user_login_authenticate');
dispatch_get('/user/logout', 'user_logout');
dispatch_post('/user/logout', 'user_logout');

// Must be the last entry in the order of controller actions
dispatch_post('/**', 'webnaplo_home');
dispatch_get('/**', 'webnaplo_home');

// Run the application
run();

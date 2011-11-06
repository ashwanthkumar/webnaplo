<?php

/**
 *	Central controller for the entire webnaplo application 
 *
 *	@author Team WebnNaplo
 *	@date 06/11/2011 - Sunday
 **/

// We're using the Limanade Micro PHP Framework
require_once("lib/limonade/limonade.php");

function configure() {
	option('env', ENV_DEVELOPMENT);
	option('limonade_views_dir', file_path(dirname(__FILE__), 'lib', 'limonade', 'views'));
	option('limonade_public_dir', file_path(dirname(__FILE__), 'lib', 'limonade', 'public'));
	option('controllers_dir', file_path(dirname(__FILE__), 'controllers'));
	
	// Include all the models to the system
	require_once_dir(file_path(dirname(__FILE__), 'models'));
	require_once_dir(file_path(dirname(__FILE__), 'lib'));
	
	// Configuration file for the entire application
	$db_host = "localhost";	// Databse host to connect to
	$db_port = 3306;	// Database port number to connect to
	$db_user = "root";	// Database User
	$db_pass = "";	// Database password
	
	$db_name = "web naplo";	// Name of the database
	
	$db = new db("mysql:host=$db_host;port=$db_port;dbname=$db_name", "$db_user", "$db_pass");
	$db->setErrorCallbackFunction("showError", "text");
	
	$GLOBALS['db'] = $db;
}

function showError($message) {
	// header("Content-type: application/json");
	// return json(array("status" => false, "message" => $message));
	html($message);
}

function before($route) {
  // header("X-LIM-route-function: ".$route['callback']);
  // layout('layout.html.php');
}

// -------------------------------------------
// Delete Dataentry controllers
// -------------------------------------------
dispatch_get('/dataentry/course/delete/', 'delete_course_render');
dispatch_post('/dataentry/course/delete/', 'delete_course_post');

dispatch_get('/dataentry/student/delete/', 'delete_student_render');
dispatch_post('/dataentry/student/delete/', 'delete_student_post');

dispatch_get('/dataentry/staff/delete/', 'delete_staff_render');
dispatch_post('/dataentry/staff/delete/', 'delete_staff_post');

dispatch_get('/dataentry/programme/delete/', 'delete_programme_render');
dispatch_post('/dataentry/programme/delete/', 'delete_programme_post');

dispatch_get('/dataentry/department/delete/', 'delete_department_render');
dispatch_post('/dataentry/department/delete/', 'delete_department_post');

// -------------------------------------------
// Add Dataentry controllers
// -------------------------------------------
dispatch_get('/dataentry/course/add/', 'add_course_render');
dispatch_post('/dataentry/course/add/', 'add_course_post');

dispatch_get('/dataentry/department/add/', 'add_department_render');
dispatch_post('/dataentry/department/add/', 'add_department_post');

dispatch_get('/dataentry/programme/add/', 'add_programme_render');
dispatch_post('/dataentry/programme/add/', 'add_programme_post');

dispatch_get('/dataentry/section/add/', 'add_section_render');
dispatch_post('/dataentry/section/add/', 'add_section_post');

dispatch_get('/dataentry/staff/add/', 'add_staff_render');
dispatch_post('/dataentry/staff/add/', 'add_staff_post');

dispatch_get('/dataentry/student/add/', 'add_student_render');
dispatch_post('/dataentry/student/add/', 'add_student_post');

// ------------------------------------------
// Edit Dataentry controllers
// ------------------------------------------
dispatch_get('^/dataentry/course/(\d+)/edit', 'edit_course_render');
dispatch_get('^/dataentry/course/edit', 'edit_course_render');
dispatch_post('^/dataentry/course/(\d+)/edit', 'edit_course_post');

dispatch_get('^/dataentry/department/(\d+)/edit', 'edit_department_render');
dispatch_post('^/dataentry/department/(\d+)/edit', 'edit_department_post');

dispatch_get('^/dataentry/programme/(\d+)/edit/', 'edit_programme_render');
dispatch_post('^/dataentry/programme/(\d+)/edit/', 'edit_programme_post');

dispatch_get('^/dataentry/section/(\d+)/edit/', 'edit_section_render');
dispatch_post('^/dataentry/section/(\d+)/edit/', 'edit_section_post');

dispatch_get('^/dataentry/staff/(\d+)/edit/', 'edit_staff_render');
dispatch_post('^/dataentry/staff/(\d+)/edit/', 'edit_staff_post');

dispatch_get('^/dataentry/student/(\d+)/edit/', 'edit_student_render');
dispatch_post('^/dataentry/student/(\d+)/edit/', 'edit_student_post');

// ------------------------------------------
// List Dataentry controllers
// ------------------------------------------
dispatch_get('/dataentry/programme/list/', 'list_programme_render');
dispatch_post('/dataentry/programme/list/', 'list_programme_post');

dispatch_get('/dataentry/section/list/', 'list_section_render');
dispatch_post('/dataentry/section/list/', 'list_section_post');

dispatch_get('/dataentry/staff/list/', 'list_staff_render');
dispatch_post('/dataentry/staff/list/', 'list_staff_post');

dispatch_get('/dataentry/course/list/', 'list_student_render');
dispatch_post('/dataentry/course/list/', 'list_student_post');

run();

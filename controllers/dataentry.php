<?php
/**
 *	DataEntry Controller for performing various functions by Dataentry user
 *
 *	@author Team WebNaplo
 *	@date 11/11/2011
 *	@since 1.0
 **/

/**
 * Data Entry Home Page
 *
 *	@method GET
 *	@route /dataentry/home/
 **/
function dataentry_home() {
	layout('dataentry/layout.html.php');
	set("title" ,"Data Entry - Home");
	set("home_active" ,"true");

    return render("dataentry/dataentry.home.html.php");
}

/**
 * Add Student View Page
 *
 *	@method GET
 *	@route /dataentry/student/add/
 **/
function dataentry_add_student_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Add student");
	set("add_active" ,"true");

    return render("dataentry/add.student.html.php");
}

/**
 * Add Student to the system
 *
 *	@method	POST
 *	@route	/dataentry/student/add/
 **/
function dataentry_add_student_post() {
	$db = $GLOBALS['db'];
	// $did = $_POST['dept_FK'];
	extract($_POST);

	// Delete the student static function to delete the object
	$r = Student::LoadAndSave($_POST, $db);

	if(is_object($r) && get_class($r) == "PDOException") {
		switch($r->getCode()) {
			case 23000:
				flash('error', "Student with the register number already exist");
				break;
			default:
				flash('error', 'There was an error adding a student, please try again later.');
				break;
		}
		return redirect('/dataentry/student/add');
	} 
	
	flash('success', "Student $name has been successfully added");
	
	// Redirect the user back 
	return redirect('/dataentry/student/add');
}

/**
 * Add Department View Page
 *
 *	@method	GET
 *	@route	/dataentry/department/add/
 **/
function dataentry_add_department_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Add Department");
	set("add_active" ,"true");

    return render("dataentry/add.department.html.php");
}

/**
 * Add Department to the system
 *
 *	@method 	POST
 *	@route		/dataentry/department/add/
 **/
function dataentry_add_department_post() {
	extract($_POST);
	
	if(strlen(trim($name)) < 1) {
		flash('error', "Please enter valid Department name");
	} else {
	
		$db = $GLOBALS['db'];

		// Delete the department static function to delete the object
		$department = Department::LoadAndSave($_POST, $db);
		if(!$department) {
			flash('error', "$name Department already exists");
		} else {
			flash('success', "Department $name has been successfully added");
		}
	}	
	
	// Redirect the user back 
	return redirect('/dataentry/department/add');
}

/**
 *	Method actings as an AJAX proxy during Student Addition
 *
 *	@method	GET
 *	@route	/dataentry/student/add/proxy
 **/
function dataentry_add_student_proxy() {
	$db = $GLOBALS['db'];
	// Get the list of programmes for the given department
	if(isset($_GET['dept'])) {
		$d = $_GET['dept'];
		
		// header("Content-type: application/json");
		$pgms = $db->select("programme", "dept_id = :d", array(":d" => $d));
		
		return json(array("data" => $pgms));
	}

	if(isset($_GET['pgm'])) {
		$p = $_GET['pgm'];
		
		$class = $db->select("class", "programme_id = :p", array(":p" => $p));
		
		return json(array("data" => $class));
	}
}

/**
 * Add programme View page
 *
 *	@method	GET
 *	@route	/dataentry/programme/add/
 **/
function dataentry_add_programme_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Add Programme");
	set("add_active" ,"true");

    return render("dataentry/add.programme.html.php");
}

/**
 * Add Programme to the system
 *
 *	@method	POST
 *	@route	/dataentry/programme/add/
 **/
function dataentry_add_programme_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);
	$db = $GLOBALS['db'];

	// Delete the programme static function to delete the object
	$r = Programme::LoadAndSave($_POST, $db);
	
	if(is_bool($r) && $r == false) {
		flash('warning', 'Programme already exist. Please try with another name');
		return redirect('/dataentry/programme/add');
	}
	
	if(is_object($r) && get_class($r) == "PDOException") {
		flash('error', 'Programme cannot be created. Please try again. Error: ' . $r->getMessage());
		return redirect('/dataentry/programme/add');
	} 
	
	flash('success', "Programme $name has been successfully added");
	
	// Redirect the user back 
	return redirect('/dataentry/programme/add');
}

/**
 * Add Section View page
 *
 *	@method	GET
 *	@route	/dataentry/section/add/
 **/
function dataentry_add_section_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Add Section");
	set("add_active" ,"true");

    return render("dataentry/add.section.html.php");
}

/**
 * Add Section View page
 *
 *	@method	POST
 *	@route	/dataentry/section/add/
 **/
function dataentry_add_section_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);
	$db = $GLOBALS['db'];

	// Delete the section static function to delete the object
	$r = Section::LoadAndSave($_POST, $db);
	
	if(is_bool($r) && $r == false) {
		flash('warning', 'Section already exist. Please try with another name');
		return redirect('/dataentry/section/add');
	}
	
	if(is_object($r) && get_class($r) == "PDOException") {
		flash('error', 'Section cannot be created. Please try again. Error: ' . $r->getMessage());
		return redirect('/dataentry/section/add');
	} 

	flash('success', "Section $name has been successfully added");
	
	// Redirect the user back 
	return redirect('/dataentry/section/add');
}

/**
 * Add Staff View Page
 *
 *	@method	GET
 *	@route	/dataentry/staff/add/
 **/
function dataentry_add_staff_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Add Staff");
	set("add_active" ,"true");

    return render("dataentry/add.staff.html.php");
}

/**
 * Add Staff to the system
 *
 *	@method	POST
 *	@route	/dataentry/staff/add/
 **/
function dataentry_add_staff_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);

	// Delete the staff static function to delete the object
	$r = Staff::LoadAndSave($_POST, $GLOBALS['db']);

	if(is_bool($r) && $r == false) {
		flash('warning', 'Staff with $staff_id already exist. Please try with another name');
		return redirect('/dataentry/staff/add');
	}
	
	if(is_object($r) && get_class($r) == "PDOException") {
		flash('error', 'Staff cannot be created. Please try again. Error: ' . $r->getMessage());
		return redirect('/dataentry/staff/add');
	} 
	
	flash('success', "Staff $name has been successfully added");
	
	// Redirect the user back 
	return redirect('/dataentry/staff/add');
}

/**
 * Add Course View Page
 *
 *	@method	GET
 *	@route	/dataentry/course/add/
 **/
function dataentry_add_course_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Add Course");
	set("add_active" ,"true");

    return render("dataentry/add.course.html.php");
}

/**
 * Add Course to the system
 *
 *	@method	POST
 *	@route	/dataentry/course/add/
 **/
function dataentry_add_course_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);

	$r = Course::LoadAndSave($_POST, $GLOBALS['db']);

	print_r($r);
	
	if(is_bool($r) && $r === FALSE) {
		flash('warning', "Course with Course Code ($coursecode) already exist. Please try with another name");
		return redirect('/dataentry/course/add');
	}
	
	if(is_object($r) && get_class($r) == "PDOException") {
		// flash('error', "Course cannot be created. Please try again. Error: " . $r->getMessage());
		halt(SERVER_ERROR, $r->getMessage());
		// return redirect('/dataentry/course/add');
	} 

	flash('success', "Course $coursename has been successfully added");
	
	// Redirect the user back 
	return redirect('/dataentry/course/add');
}

/**
 *	Change the password of the dataentry user
 *
 *	@method POST
 *	@route	/dataentry/changepass/
 **/
function dataentry_changepass() {
	if(isset($_POST['newPass'])) {
		$newPass = $_POST['newPass'];
		
		flash('success', "Your password has been successfully updated");
		Configuration::put(Configuration::$CONFIG_DATAENTRY_PASSWORD, $newPass, $GLOBALS['db']);
		return redirect("/dataentry/home");
	} else {
		return redirect("/dataentry/home");
	}
}

/**
 *	List Staff Members of the system
 *
 *	@method	GET
 *	@route	/dataentry/staff/list/
 **/
function dataentry_list_staff_render() {
	return list_staff_render();
}

function list_staff_render() {
	$user = get_user();
	layout($user->type . '/layout.html.php');
	set('title', "Staff List");
	set('list_active', "true");
	
	return render("/dataentry/dataentry.list.staff.php");
}

/**
 *	List All Programmes of the system
 *
 *	@method	GET
 *	@route	/dataentry/programme/list/
 **/
function dataentry_list_programme_render() {
	return list_programme_render();
}

function list_programme_render() {
	$user = get_user();
	layout($user->type . '/layout.html.php');
	set('title', "Programme List");
	set('list_active', "true");
	
	return render("/dataentry/dataentry.list.programme.php");
}

/**
 *	List all Courses of the system
 *
 *	@method	GET
 *	@route	/dataentry/course/list/
 **/
function dataentry_list_course_render() {
	return list_course_render();
}

function list_course_render() {
	$user = get_user();
	layout($user->type . '/layout.html.php');
	set('title', "Course List");
	set('list_active', "true");
	
	return render("/dataentry/dataentry.list.course.php");
}

/**
 *	Used by wkhtmltopdf for generating PDFs in the system
 *
 *	@method	GET
 *	@route	/dataentry/report/list/:type
 **/
function dataentry_report_list() {
	$type = params('type');
	return render("/dataentry/export/dataentry.$type.list.html.php");
}

/**
 *	Used to initiate the export operation using wkhtmltopdf
 *
 *	@method	GET
 *	@route	/dataentry/export/list/:type
 **/
function dataentry_export_list() {
	$type = params('type');
	
	switch($type) {
		case "staff":
			$print_url = "http://" . $_SERVER['SERVER_NAME'] . url_for('/admin/report/list/staff'); 
			$pdf_path = WTK::exportPDF($print_url);
			return render_file($pdf_path);
			break;
		case "programme":
			$print_url = "http://" . $_SERVER['SERVER_NAME'] . url_for('/admin/report/list/programme'); 
			$pdf_path = WTK::exportPDF($print_url);
			return render_file($pdf_path);
			break;
		case "student":
			$print_url = "http://" . $_SERVER['SERVER_NAME'] . url_for('/admin/report/list/student'); 
			$pdf_path = WTK::exportPDF($print_url);
			return render_file($pdf_path);
			break;
		case "section":
			$print_url = "http://" . $_SERVER['SERVER_NAME'] . url_for('/admin/report/list/section'); 
			$pdf_path = WTK::exportPDF($print_url);
			return render_file($pdf_path);
			break;
		case "course":
			$print_url = "http://" . $_SERVER['SERVER_NAME'] . url_for('/admin/report/list/course'); 
			$pdf_path = WTK::exportPDF($print_url);
			return render_file($pdf_path);
			break;
		default:
			break;
	}
}

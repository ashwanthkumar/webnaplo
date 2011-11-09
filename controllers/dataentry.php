<?php
/**
 *	DataEntry Controller for performing various functions
 *
 *	@author Team WebNaplo
 *	@date 08/11/2011
 **/

/**
 * Delete Student View Page
 **/
function delete_student_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Delete Student");
	set("delete_active" ,"true");

    return render("dataentry/delstud.html.php");
}

/**
 * Data Entry Home Page
 **/
function dataentry_home() {
	layout('dataentry/layout.html.php');
	set("title" ,"Data Entry - Home");
	set("home_active" ,"true");

    return render("dataentry/dataentry.home.html.php");
}

/**
 * Delete the Student from the dataentry
 **/
function delete_student_post() {
	$reg = $_POST['regno'];

	// Delete the student static function to delete the object
	$r = Student::Delete($reg, $GLOBALS['db']);
	if(is_object($r) && get_class($r) == "PDOException") {
		
		switch($r->getCode()) {
			case 23000:
				$msg = "There are other dependencies for the given Student, delete them before deleting this student";
			break;
		}
		
		flash('error', $msg);
	} else {
		if($r == 0) {
			flash('warning', "Student with $reg was not found in the system");
		} else {
			flash('success', "Student with $reg has been successfully deleted");
		}
	}
	
	// Redirect the user back 
	redirect('/dataentry/student/delete');
}

/**
 * Delete Staff view page
 **/
function delete_staff_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Delete Staff");
	set("delete_active" ,"true");

    return render("dataentry/delstaff.html.php");
}

/**
 * Delete Staff from the system
 **/
function delete_staff_post() {
	$staffid = $_POST['staffid'];

	$db = $GLOBALS['db'];
	// Delete the student static function to delete the object
	$r = Staff::Delete($staffid, $db);
	
	if(is_object($r) && get_class($r) == "PDOException") {
		
		switch($r->getCode()) {
			case 23000:
				$msg = "There are other dependencies for the given Staff, delete them before deleting this Staff";
			break;
		}
		
		flash('error', $msg);
	} else {
		if($r == 0) {
			flash('warning', "Staff with $staffid is not found in the system");
		} else {
			flash('success', "Staff with $staffid has been successfully deleted");
		}
	}
	
	// Redirect the user back 
	redirect('/dataentry/staff/delete');
}

/**
 * Delete Programme View Page
 **/
function delete_programme_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Delete Programme");
	set("delete_active" ,"true");

    return render("dataentry/delprog.html.php");
}

/**
 * Delete the programme from the system
 **/
function delete_programme_post() {
	$pgmid = $_POST['Programme_FK'];

	$db = $GLOBALS['db'];
	
	// Delete the student static function to delete the object
	$r = Programme::Delete($pgmid, $db);
	if(is_object($r) && get_class($r) == "PDOException") {
		
		switch($r->getCode()) {
			case 23000:
				$msg = "There are other dependencies for the given Programme, delete them before deleting this programme";
			break;
		}
		
		flash('error', $msg);
	} else {
		if($r == 0) {
			flash('warning', "Programme is not found in the system");
		} else {
			flash('success', "Programme has been successfully deleted");
		}
	}
	
	// Redirect the user back 
	redirect('/dataentry/programme/delete');
}

/**
 * Delete Course View page
 **/
function delete_course_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Delete Course");
	set("delete_active" ,"true");

    return render("dataentry/delcourse.html.php");
}

/**
 * Delete post from the system
 **/
function delete_course_post() {
	$cid = $_POST['coursecode'];

	// Delete the student static function to delete the object
	$r = Course::Delete($cid, $GLOBALS['db']);
	if(is_object($r) && get_class($r) == "PDOException") {
		
		switch($r->getCode()) {
			case 23000:
				$msg = "There are other dependencies for the given Course, delete them before deleting this Course";
			break;
		}
		
		flash('error', $msg);
	} else {
		if($r == 0) {
			flash('warning', "Course with $cid not found in the system");
		} else {
			flash('success', "Course with $cid has been successfully deleted");
		}
	}
	
	// Redirect the user back 
	redirect('/dataentry/course/delete');
}

/**
 * Delete Department page
 **/
function delete_department_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Delete Department");
	set("delete_active" ,"true");

    return render("dataentry/deldept.html.php");
}

/**
 * Delete programme from the system
 **/
function delete_department_post() {
	$did = $_POST['dept_FK'];
	
	// Move this to Department Model class
	$db = $GLOBALS['db'];

	// Delete the student static function to delete the object
	$r = Department::Delete($did, $db);
	
	if(is_object($r) && get_class($r) == "PDOException") {
		
		switch($r->getCode()) {
			case 23000:
				$msg = "There are other dependencies for the given Department, delete them before deleting this department";
			break;
		}
		
		flash('error', $msg);
	} else {
		if($r == 0) {
			flash('warning', "Department was not found in the system");
		} else {
			flash('success', "Department has been successfully deleted");
		}
	}
	
	// Redirect the user back 
	redirect('/dataentry/department/delete');
}

/**
 * Edit Course View Page
 **/
function edit_course_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Edit Course");
	set("edit_active" ,"true");

    return render("dataentry/edit.course.html.php");
}

/**
 * Edit Course in the system
 **/
function edit_course_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);

	// Delete the student static function to delete the object
	$r = Course::LoadAndUpdate($_POST, $GLOBALS['db']);
	if(is_object($r) && get_class($r) == "PDOException") {
		
		switch($r->getCode()) {
			case 23000:
				$msg = "There are other dependencies for the given Department, delete them before deleting this department";
			break;
		}
		
		flash('error', $msg);
	} else {
		if($r == 0) {
			flash('warning', "Course was not found in the system");
		} else {
			flash('success', "Course $courseName has been successfully edited");
		}
	}
	
	// Redirect the user back 
	redirect("/dataentry/course/$idcourse/edit");
}

/**
 * Edit Department View Page
 **/
function edit_department_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Edit Department");
	set("edit_active" ,"true");

    return render("dataentry/edit.department.html.php");
}

/**
 * Edit Department, existing from the system
 **/
function edit_department_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);

	// Delete the student static function to delete the object
	Department::LoadAndUpdate($_POST);
	flash('success', "department $departmentName has been successfully edited");
	
	// Redirect the user back 
	redirect('/dataentry/department/edit');
}

/**
 * Edit Programme View Page
 **/
function edit_programme_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Edit Programme");
	set("edit_active" ,"true");

    return render("dataentry/edit.programme.html.php");
}

/**
 * Edit Programme in the system
 **/
function edit_programme_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);

	// Delete the student static function to delete the object
	Programme::LoadAndUpdate($_POST);
	flash('success', "Programme has been successfully edited");
	
	// Redirect the user back 
	redirect('/dataentry/programme/edit');
}

/**
 * Edit Staff View page
 **/
function edit_staff_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Edit Staff");
	set("edit_active" ,"true");

    return render("dataentry/edit.staff.html.php");
}

/**
 * Edit Staff in the system
 **/
function edit_staff_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);

	// Delete the student static function to delete the object
	Staff::LoadAndUpdate($_POST);
	flash('success', "Staff $staffName has been successfully edited");
	
	// Redirect the user back 
	redirect('/dataentry/staff/edit');
}

/**
 * Edit Student View page
 **/
function edit_student_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Edit student");
	set("edit_active" ,"true");

    return render("dataentry/edit.student.html.php");
}

/**
 * Edit Student in the system
 **/
function edit_student_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);

	// Delete the student static function to delete the object
	Student::LoadAndUpdate($_POST);
	flash('success', "Student $name has been successfully deleted");
	
	// Redirect the user back 
	redirect('/dataentry/student/edit');
}

/**
 * Add Student View Page
 **/
function add_student_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Add student");
	set("add_active" ,"true");

    return render("dataentry/add.student.html.php");
}

/**
 * Add Student to the system
 **/
function add_student_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);

	// Delete the student static function to delete the object
	Student::Save($_POST);
	flash('success', "Student $name has been successfully added");
	
	// Redirect the user back 
	redirect('/dataentry/student/add');
}

/**
 * Add Department View Page
 **/
function add_department_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Add Department");
	set("add_active" ,"true");

    return render("dataentry/add.department.html.php");
}

/**
 * Add Department to the system
 **/
function add_department_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);

	// Delete the department static function to delete the object
	Department::Save($_POST);
	flash('success', "Department $deptname has been successfully added");
	
	// Redirect the user back 
	redirect('/dataentry/department/add');
}

/**
 * Add programme View page
 **/
function add_programme_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Add Programme");
	set("add_active" ,"true");

    return render("dataentry/add.programme.html.php");
}

/**
 * Add Programme to the system
 **/
function add_programme_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);

	// Delete the programme static function to delete the object
	Programme::Save($_POST);
	flash('success', "Programme $name has been successfully added");
	
	// Redirect the user back 
	redirect('/dataentry/programme/add');
}

/**
 * Add Section View page
 **/
function add_section_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Add Section");
	set("add_active" ,"true");

    return render("dataentry/add.section.html.php");
}

/**
 * Add Section View page
 **/
function add_section_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);

	// Delete the section static function to delete the object
	Section::Save($_POST);
	flash('success', "Section $name has been successfully added");
	
	// Redirect the user back 
	redirect('/dataentry/section/add');
}

/**
 * Add Staff View Page
 **/
function add_staff_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Add Staff");
	set("add_active" ,"true");

    return render("dataentry/add.staff.html.php");
}

/**
 * Add Staff to the system
 **/
function add_staff_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);

	// Delete the staff static function to delete the object
	Staff::Save($_POST);
	flash('success', "Staff $name has been successfully added");
	
	// Redirect the user back 
	redirect('/dataentry/staff/add');
}

/**
 * Add Course View Page
 **/
function add_course_render() {
	layout('dataentry/layout.html.php');
	set("title" ,"Add Course");
	set("add_active" ,"true");

    return render("dataentry/add.course.html.php");
}

/**
 * Add Course to the system
 **/
function add_course_post() {
	// $did = $_POST['dept_FK'];
	extract($_POST);

	// Delete the course static function to delete the object
	Course::Save($_POST);
	flash('success', "Course $name has been successfully added");
	
	// Redirect the user back 
	redirect('/dataentry/course/add');
}


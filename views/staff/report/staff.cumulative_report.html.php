<?php

	/**
	 *	View Page to render the Cummulative Report for a particular Course Profile. 
	 *	Used by HTML2PDF Rendering engines to convert this HTML page to PDF.
	 **/
	// PDOObject
	$db = $GLOBALS['db'];
	
	// Set the default time zone to Asia
	date_default_timezone_set("Asia/Calcutta");
	
	$course = Course::load(CourseProfile::load($cpid, $db)->course_id, $db);
	$student_list = $db->run("select s.idstudent as idstudent from student s, cp_has_student chs where chs.cp_id = :cpid and s.idstudent = chs.idstudent", array(":cpid" => $cpid));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cumulative Report for <?php echo $course->coursename; ?></title>
</head>

<body>
<h1 align="center">Cumulative Report for <?php echo $course->coursename; ?></h1>
<table width="100%" border="1">
  <tr>
    <th scope="col">Reg.</th>
    <th scope="col">Name</th>
    <th scope="col">CIA I</th>
    <th scope="col">CIA II</th>
    <th scope="col">CIA III</th>
    <th scope="col">Assign</th>
    <th scope="col">Internal </th>
    <th scope="col">Atten.</th>
    <th scope="col">Confirm</th>
  </tr>
  <?php 
		foreach($student_list as $_student) {

			$student = Student::load($_student['idstudent'], $db);

			$marks = $student->getCIAMarksForCourseProfile($cpid, $db);
			$internals = $student->calcInternalsForCourseProfile($cpid, $db);
			$attendance_summary = $student->getAttendanceSummaryForCourseProfile($cpid, $db);
	?>
  <tr>
    <td style="text-align: right;"><?php echo $student->idstudent; ?></td>
    <td style="text-align: left;"><?php echo $student->name; ?></td>
    <td style="text-align: right;">
	<?php 
		if(is_null($marks['mark_1'])) echo "N/A"; 
		else echo $marks['mark_1'];
	?>
	</td>
    <td style="text-align: right;">
	<?php 
		if(is_null($marks['mark_2'])) echo "N/A"; 
		else echo $marks['mark_2'];
	?>
	</td>
    <td style="text-align: right;">
	<?php 
		if(is_null($marks['mark_3'])) echo "N/A"; 
		else echo $marks['mark_3'];
	?>
	</td>
    <td style="text-align: right;">
	<?php 
		if(is_null($marks['assignment'])) echo "N/A"; 
		else echo $marks['assignment'];
	?>
	</td>
    <td style="text-align: right;"><?php echo $internals; ?></td>
    <td style="text-align: right;">
	<?php 
		if($attendance_summary['percentage'] == "N/A") echo "N/A";
		else echo $attendance_summary['percentage'] . "%";
	?>
	</td>
    <td style="text-align: center;"><?php 
		if($marks['is_confirmed'] == 1) {
		?>
			<img src="<?php echo url_for('public/icons/tick/tick_16.png'); ?>" />
		<?php
		} else {
		?>
			<img src="<?php echo url_for('public/icons/delete/delete_16.png'); ?>" />
		<?php
			}
		?>
	</td>
  </tr>
  <?php
		}
	?>
</table>

<div style="">
	<p style="text-align: right;">&copy; 2011 Team Webnaplo. Generated with WebNaplo (Beta) Export. </p>
	<p style="text-align: right;">Generated on <?php echo date('r', time()); ?> </p>
</div>

</body>
</html>

<?php

	$db = $GLOBALS['db'];
	
	$programmes = $db->run("select p.idprogramme as idprogramme, d.iddept as iddept, p.name as pname, d.name as dname, c.course_name as course_name, c.course_code as course_code, c.credits as credits from programme p, dept d, course c where c.programme_id = p.idprogramme and p.dept_id = d.iddept");
	
	// Set the default time zone to Asia
	date_default_timezone_set("Asia/Calcutta");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Course List</title>
</head>

<body>
<h1 align="center">Complete Course List</h1>
<table width="100%" border="1">
  <tr>
    <th scope="col">SNO </th>
    <th scope="col">Course Code </th>
    <th scope="col">Course Name </th>
    <th scope="col">Credits </th>
    <th scope="col">Programme </th>
    <th scope="col">Department </th>
  </tr>
  <?php 
			$i = 1;
			foreach($programmes as $programme) {
	?>
  <tr>
	<td><?php echo $i++; ?></td>
	<td><?php echo $programme['pname']; ?></td>
	<td><?php echo $programme['course_name']; ?></td>
	<td><?php echo $programme['credits']; ?></td>
	<td><?php echo $programme['pname']; ?></td>
	<td><?php echo $programme['dname']; ?></td>
  </tr>
  <?php
		}
	?>
</table>

<p style="text-align: right;">&copy; 2011 Team Webnaplo. Generated with WebNaplo (Beta) Export. </p>
<p style="text-align: right;">Generated on <?php echo date('r', time()); ?> </p>
</body>
</html>

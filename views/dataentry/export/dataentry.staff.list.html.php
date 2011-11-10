<?php

	$db = $GLOBALS['db'];
	
	$staffs = $db->select("staff", "1=1 order by name");
	
	// Set the default time zone to Asia
	date_default_timezone_set("Asia/Calcutta");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Staff List</title>
</head>

<body>
<h1 align="center">Complete Staff List</h1>
<table width="100%" border="1">
  <tr>
    <th scope="col">SNO</th>
    <th scope="col">Staff Id</th>
    <th scope="col">Designation</th>
    <th scope="col">Name</th>
    <th scope="col">EMail</th>
    <th scope="col">Mobile</th>
  </tr>
  <?php 
			$i = 1;
			foreach($staffs as $staff) {
	?>
  <tr>
    <td><?php echo $i++; ?></td>
    <td><?php echo $staff['staff_id']; ?></td>
    <td><?php echo $staff['designation']; ?></td>
    <td><?php echo $staff['name']; ?></td>
    <td><?php echo $staff['email']; ?></td>
    <td><?php echo $staff['mobile']; ?></td>
  </tr>
  <?php
		}
	?>
</table>

<p style="text-align: right;">&copy; 2011 Team Webnaplo. Generated with WebNaplo (Beta) Export. </p>
<p style="text-align: right;">Generated on <?php echo date('r', time()); ?> </p>
</body>
</html>

<?php

	// Get the current user under the context
	$user = get_user();
	// Get the PDOObject instance
	$db = $GLOBALS['db'];
	
	// Load the current student under context
	$student = Student::load($user->userid, $db);
	
	// Available time slots in the university
	// Array index wantedly started from 1 and not from 0. Please preserve it when changing
	// @TODO Copied from ./views/staff/staff.timetabl.popup.html.php
	// If you happen to change it here, please change it there too
	$timeslots = array(1 => "07.30 - 08.40", "08.40 - 09.30", "09.30 - 10.20", "10.20 - 11.10", "10.40 - 11.30", "11.30 - 12.20", "12.20 - 13.10", "13.10 - 14.00", "14.10 - 15.00", "15.00 - 15.50", "16.00 - 16.50", "16.50 - 17.40", "17.40 - 18.30");

	// Get the timetable details of this student
	$student_timetable = $student->getTimetable($db);

	// List of Courses
	$course_list = Student::getCoursesList($student->idstudent, $db);
	
	content_for('body');
?>
<!-- 100% Box Grid Container: Start -->
<div class="grid_24">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames"><?php echo get_text('TIMETABLE'); ?></h1>
	</div>
	<!-- Box Header: End -->
	
	
	<!-- Box Content: Start -->
	<div class="box_content">
		<table cellpadding="5" cellspacing="5" width="100%" border="1" class="nostyle">
			<thead style="background: yellow;color: black;">
				<th><?php echo get_text('TIMESLOTS'); ?> / <?php echo get_text('DAYS'); ?></th>
				<th><?php echo get_text('MONDAY'); ?></th>
				<th><?php echo get_text('TUESDAY'); ?></th>
				<th><?php echo get_text('WEDNESDAY'); ?></th>
				<th><?php echo get_text('THURSDAY'); ?></th>
				<th><?php echo get_text('FRIDAY'); ?></th>
			</thead>
			
			<tbody>
			<?php
				while($timeslot = current($timeslots)) {
			?>
				<tr>
					<td><?php echo $timeslot; ?></td>
					<td><?php echo displayCourse($student_timetable, 1, key($timeslots)) ?></td>
					<td><?php echo displayCourse($student_timetable, 2, key($timeslots)) ?></td>
					<td><?php echo displayCourse($student_timetable, 3, key($timeslots)) ?></td>
					<td><?php echo displayCourse($student_timetable, 4, key($timeslots)) ?></td>
					<td><?php echo displayCourse($student_timetable, 5, key($timeslots)) ?></td>
				</tr>
			<?php
					next($timeslots);
				}
			?>
			</tbody>
		</table>
	</div>
	<!-- Box Content: End -->

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames"><?php echo get_text('STUDENT') . " " . get_text('COURSE') . " " . get_text('LIST'); ?></h1>
	</div>
	<!-- Box Header: End -->
	
	<div class="box_content ">
		<table>
			<thead>
				<td>Course Code </td>
				<td>Course Name </td>
				<td>Credits </td>
			</thead>
			
			<tbody>
			<?php
				foreach($course_list as $course) {
			?>
				<tr>
					<td><?php echo $course['course_code']; ?></td>
					<td><?php echo $course['course_name']; ?></td>
					<td><?php echo $course['credits']; ?></td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>
	</div>
</div>
<!-- 100% Box Grid Container: End -->

<?php
	end_content_for();

	/**
	 *	Display the course in the student timetable
	 **/
	function displayCourse($tt, $day, $hour) {
		$tt_offset = $day . '_' . $hour;
		
		if(isset($tt[$tt_offset])) return $tt[$tt_offset]['course_code'];
		else echo "Free Hour";
	}
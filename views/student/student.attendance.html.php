<?php

	$db = $GLOBALS['db'];
	
	// Get the current user in the context
	$user = get_user();
	
	// Get the student object
	$student = Student::load($user->userid, $db);
	
	$attendance = $student->getAttendance($db);
	
	content_for('body');
?>
<!-- 100% Box Grid Container: Start -->
<div class="grid_24">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames"><?php echo get_text('ATTENDANCE'); ?></h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content">
		<table>
			<thead>
				<tr>
					<th class="align_left center"><?php echo get_text('COURSE'); ?></th>
					<th class="align_left center"><?php echo get_text('HOURS_PRESENT'); ?></th>
					<th class="align_left center"><?php echo get_text('HOURS_TOTAL'); ?></th>
					<th class="align_left center"><?php echo get_text('PERCENTAGE'); ?></th>
				</tr>
			</thead>
			
			<tbody>	
			<?php
				$courses = Student::getCoursesList($student->idstudent, $db);
				
				foreach($courses as $course) {
					$attendance_summary = $student->getAttendanceSummaryForCourseProfile($course['cpid'], $db);
						
					$hours_present = $attendance_summary['present'];
					$total_count = $attendance_summary['total'];
					$percentage = $attendance_summary['percentage'];
					
					if($percentage < 75) $row_class='style="color: red;"'; // Mark the entire row as red to denote as warning
			?>
				<tr class="error" <?php echo $row_class; ?> >
					<td class="align_left center"><?php echo $course['course_name']; ?> </td>
					<td class="align_left center"><?php echo $hours_present; ?> </td>
					<td class="align_left center"><?php echo $total_count; ?> </td>
					<td class="align_left center"><?php echo $percentage; ?> </td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->
<?php
	end_content_for();

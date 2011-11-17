<?php

	// Get the current user from the application
	$user = get_user();

	$db = $GLOBALS['db'];

	// Select the list of course profiles the staff takes
	$courses = $db->select("course_profile", "staff_id = :id", array(":id" => $user->userid));

	content_for('body');
?>
<!-- 75% Box Grid Container: Start -->
<div class="grid_18">

	<!-- Box Header: Start -->
	<div class="box_top">
		
		<h1 class="icon frames">TimeTable of <?php echo $user->name; ?></h1>
		
	</div>
	<!-- Box Header: End -->
	
	
	<!-- Box Content: Start -->
	<div class="box_content">
		<div class="field noline">
			<!-- Lets create first for posting the attendance -->
			<!-- Timetable table layout: START -->
			<table colspan="1">
				<thead>
					<th>&nbsp;</th>
					<th>Monday</th>
					<th>Tuesday</th>
					<th>Wednesday</th>
					<th>Thursday</th>
					<th>Friday</th>
				</thead>
				
				<tbody>
					<tr>
						<td>7.30 - 8.40 </td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
					</tr>
					<tr>
						<td>8.40 - 9.30 </td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
					</tr>
					<tr>
						<td>9.30 - 10.20 </td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
					</tr>
					<tr>
						<td>10.20 - 11.10 </td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
					</tr>
					<tr>
						<td>11.10 - 11.30 </td>
						<td colspan="5" class="center"><strong>BREAK</strong></td>
					</tr>
					<tr>
						<td>11.30 - 12.20 </td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
					</tr>
					<tr>
						<td>12.20 - 13.10 </td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
					</tr>
					<tr>
						<td>13.10 - 14.00  </td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
					</tr>
					<tr>
						<td>14.10 - 15.00</td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
					</tr>
					<tr>
						<td>15.00 - 15.50 </td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
					</tr>
					<tr>
						<td>16.00 - 16.50 </td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
					</tr>
					<tr>
						<td>16.50 - 17.40 </td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
					</tr>
					<tr>
						<td>17.40 - 18.30 </td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
						<td><?php echo listCourseProfiles(); ?></td>
					</tr>
				</tbody>
			</table>
			
			<div class="align_left">
				<button onclick="alert('This view isn\'t working well. Need to do something more productive');">Save Timetable</button>
			</div>
			<!-- Timetable table layout: END -->
		</div>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 75% Box Grid Container: End -->
<?php
	end_content_for();

	function listCourseProfiles() {
		// global $user;
		$user = get_user();
		$db = $GLOBALS['db'];
		$courses = $db->select("course_profile", "staff_id = :id", array(":id" => $user->userid));
	
		$r = '<select>';
		foreach($courses as $c) $r .= '<option name="' . $c['idcourse_profile'] . '">' . $c['name'] . '</option>';
		$r .= '</select>';
		
		return $r;
	}
<?php

	// Get the current user from the application
	$user = get_user();

	// Get the PDO handle
	$db = $GLOBALS['db'];

	$staff = Staff::load($user->userid, $db);
	
	if(!$staff) {
		// Seems like the user does not exist, automatically logout the user
		return redirect('/user/logout');
	}
	
	// Select the list of course profiles the staff takes
	$courses = $staff->getCourseProfiles($db);

	// Get the timetable of the current staff member
	$staff_timetable = $staff->getTimetable($db);
	
	// Custom Array which contains the timetable of the staff member in a new format
	$staff_tt_ids = array();
	foreach($staff_timetable as $st) $staff_tt_ids[$st['days_of_week'] . '_' . $st['hour_of_day']] = $st['cp_id'];


	// Available time slots in the university
	// Array index wantedly started from 1 and not from 0. Please preserve it when changing
	$timeslots = array(1 => "07.30 - 08.40", "08.40 - 09.30", "09.30 - 10.20", "10.20 - 11.10", "10.40 - 11.30", "11.30 - 12.20", "12.20 - 13.10", "13.10 - 14.00", "14.10 - 15.00", "15.00 - 15.50", "16.00 - 16.50", "16.50 - 17.40", "17.40 - 18.30");

	// Marker for the Timetable display
	content_for('body'); 
?>
<div class="grid_24" >
<?php
	if(isset($flash['success'])) :
?>
<div class="notice success">
	<p><?php echo $flash['success']; ?></p>
</div>
<?php
	endif;
?>
	<div class="box_top" style="padding-top: -100px;">
		<h1 class="icon frames center">Timetable Editor for <?php echo $user->name; ?></h1>
	</div>

	<div class="box_content">
		<form method="POST" action="<?php echo url_for('/staff/timetable/save'); ?>" id="timetableEditor">
			<!-- Timetable table layout: START -->
			<table cellpadding="5" cellspacing="5" width="100%" border="1" class="nostyle">
				<thead style="background: yellow;color: black;">
					<th>Time Slots / Days</th>
					<th>Monday</th>
					<th>Tuesday</th>
					<th>Wednesday</th>
					<th>Thursday</th>
					<th>Friday</th>
				</thead>
				
				<tbody>
				<?php
					// Print the timetable form for the staff
					while($slot = current($timeslots)) {
				?>
					<tr>
						<td class="timetableslot"><?php echo $slot; ?> </td>
						<td><?php echo listCourseProfiles($courses, $staff_tt_ids, 1, (key($timeslots))); ?></td>
						<td><?php echo listCourseProfiles($courses, $staff_tt_ids, 2, (key($timeslots))); ?></td>
						<td><?php echo listCourseProfiles($courses, $staff_tt_ids, 3, (key($timeslots))); ?></td>
						<td><?php echo listCourseProfiles($courses, $staff_tt_ids, 4, (key($timeslots))); ?></td>
						<td><?php echo listCourseProfiles($courses, $staff_tt_ids, 5, (key($timeslots))); ?></td>
					</tr>
				<?php
						next($timeslots);
					}
				?>
				</tbody>
			</table>
			
			<div class="push_10 field noline ">
				<button type="submit">Update Timetable</button>
			</div>
		</form>
	</div>
</div>
<?php

	end_content_for();
	// End of Timetable display marker

	/**
	 *	Generates the timetable select boxes for the staff members
	 *
	 *	@param	$courses		List of course profiles for the staff members
	 *	@param	$staff_tt_ids	Timetable of the staff in a custom array
	 *	@param	$day			Day of the week to generate the list box
	 *	@param	$hour			Hour of the day to generate the list box
	 *	@return <select> HTML Element
	 **/
	function listCourseProfiles($courses, $staff_tt_ids, $day, $hour) {
		
		$r = '<select name="' . $day . '_' . "$hour" . '"><option value="-1">Free </option>';
		foreach($courses as $c) {
			$array_key_test = $day . '_' . $hour;
			
			// Checking if the slot is already used by the course profile
			$selected = isset($staff_tt_ids[$array_key_test]) && ($staff_tt_ids[$array_key_test] == $c['idcourse_profile']);
			
			if($selected) $selected = " selected = 'selected' "; else $selected = "";
			$r .= '<option value="' . $c['idcourse_profile'] . '" '. $selected .'>' . $c['course_code'] . '</option>';
		}
		$r .= '</select>';
		
		return $r;
	}	

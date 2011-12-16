<?php

	// Get the PDOObject
	$db = $GLOBALS['db'];
	
	// Get the current user under the context
	$user = get_user();
	
	// Load the staff member
	$staff = Staff::load($user->userid, $db);
	
	content_for('body');
?>
<!-- 75% Box Grid Container: Start -->
<div class="grid_18">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Cumulative Report</h1>
	</div>
	<!-- Box Header: End -->
	
	
	<!-- Box Content: Start -->
	<div class="box_content">
		<table>
			<thead>
				<th><?php echo get_text('COURSE_PROFILE'); ?></th>
				<th><?php echo get_text('COURSE'); ?></th>
				<th><?php echo get_text('REPORTS'); ?></th>
			</thead>
			
			<tbody>
			<?php
				$course_list = $staff->getCourseProfiles($db);
				foreach($course_list as $cp) {
			?>
				<tr>
					<td><?php echo $cp['cpname']; ?></td>
					<td><?php echo $cp['cname']; ?></td>
					<td>
					<!-- Need to Add Attendance Lag Report, Cumulative Report Score Icons here -->
					<!-- 
						@TODO Implement the Attendance Lag Report for the Course Profile
						<img src="<?php echo url_for('public/icons/attendance/attendance_24.png'); ?>" class="push_1"/> 
					-->
					<a onclick='window.open("<?php echo url_for("/staff/cumulative_report/download/" . $cp['idcourse_profile']); ?>" ,"cumulativereport","status"); return;' href="#" class="tip" title="Download Cummulative Report as PDF"><img src="<?php echo url_for('public/icons/report/report_24.png'); ?>" class="push_1" /></a>
					</td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 75% Box Grid Container: End -->

<?php
	end_content_for();

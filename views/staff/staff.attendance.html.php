<?php

	// Get the current user using the application
	$user = get_user();

	// Getting the PDO Handler
	$db = $GLOBALS['db'];
	
	$staff = Staff::load($user->userid, $db);

	// View Page that displays the Pending Attendance
	content_for('body');
	
	$courseProfileList = $staff->getCourseProfiles($db); 
?>

<!-- 75% Box Grid Container: Start -->
<div class="grid_18">

	<!-- Box Header: Start -->
	<div class="box_top">
		
		<h1 class="icon frames">Select Course Profile to Post Attendance</h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content">	
		<div id="listing">
		<!-- Course Profile Table Listing: Start -->
		<table class="sorting">
			<thead>
				<tr>
					<th class="align_left center">Course Profile</th>
					<th class="align_left center">Course Name</th>
					<th class="align_left center tools">Tools</th>
				</tr>
			</thead>
			<tbody>
		
			<?php 	
				foreach($courseProfileList as $pa) {
			?>
				<tr>
					<td class="align_left center"><?php echo $pa['cpname']; ?></td>
					<td class="align_left center"><?php echo $pa['cname']; ?></td>
					<td class="align_left tools center">
						<a onclick="window.open('<?php echo url_for('/staff/attendance/' . $pa['idcourse_profile'] . '/popup'); ?>', 'attendance_popup','status=0,height=650,width=1000');return false;" class="edit tip" title="Post Attendance">post</a>
					</td>
				</tr>
			<?php
				}
			?>

			</tbody>
		</table>
		</div>
	</div>
	<!-- Box Content: End -->

	<div class="box_content padding">
		<div class="">
			<h3>General Instructions </h3>
			<ol>
				<li>To Edit or Post Attendance, choose the date and re-enter the attendance.  </li>
				<li>Old Attendance details are automatically updated. </li>
			</ol>
		</div>
	</div>
	
</div>
<!-- 100% Box Grid Container: End -->

<?php
	end_content_for();
	

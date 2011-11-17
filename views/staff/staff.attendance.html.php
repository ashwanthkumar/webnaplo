<?php

	// Get the current user using the application
	$user = get_user();

	// Getting the PDO Handler
	$db = $GLOBALS['db'];
	
	$staff = $db->select("staff", "idstaff = :sid", array(":sid" => $user->userid));
	$staff = $staff[0];

	// View Page that displays the Pending Attendance
	content_for('body');
	
	$pendingAttendance = Staff::getPendingAttendance($staff['staff_id'], $db); 
?>

<!-- 75% Box Grid Container: Start -->
<div class="grid_18">

	<!-- Box Header: Start -->
	<div class="box_top">
		
		<h1 class="icon frames">Pending Attendance for <?php echo $staff['name']; ?></h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content">
	<div id="listing">
	<!-- Course Profile Table Listing: Start -->
	<table class="sorting">
		<thead>
			<tr>
				<th class="align_left center">Course</th>
				<th class="align_left center">Date</th>
				<th class="align_left center">Hour</th>
				<th class="align_left center tools">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		
		<?php 	
			foreach($pendingAttendance as $pa) {
		?>
			<tr>
				<td class="align_left center"><?php echo $pa['name']; ?></td>
				<td class="align_left center"><?php echo $pa['date']; ?></td>
				<td class="align_left center"><?php echo $pa['hour']; ?></td>
				<td class="align_left tools center">
					<a href="<?php echo url_for("/staff/attendance/" . $pa['cp_id'] . "/" . strtotime($pa['date']) . "/post"); ?>" class="edit tip" title="Post Attendance for the day">view</a>
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
	
</div>
<!-- 100% Box Grid Container: End -->

<?php
	end_content_for();
	
	content_for('dashboard1');
?>
		<!-- Box Content: Start -->
	<div class="box_content">
		
		<p class="center">
			<!-- List of big icons for quicklinks -->
			<a href="tables.html" class="big_button add_user"><span>Add Staff</span></a>
			<a href="#gallery" class="big_button upload"><span>Add Section</span></a>
			<a href="#news" class="big_button add_news"><span>Edit Stud</span></a>
			<a href="tables.html" class="big_button add_event"><span>Edit Dept</span></a>
			<a href="#messages" class="big_button new_pm popup"><span>Delete Staff</span></a>
			<a href="typography.html" class="big_button support"><span>Delete Prog</span></a>
		</p>
		
	</div>
	<!-- Box Content: End -->
<?php
	end_content_for();
<?php
	// Get the user of the application
	$user = get_user();

	// Getting the PDO Handler
	$db = $GLOBALS['db'];
	
	$staff = $db->select("staff", "idstaff = :sid", array(":sid" => $user->userid));
	$staff = $staff[0];

	// Render Page Starts
	content_for('body');
	
	// Get List of course profiles for the staff members
	$course_profiles = $db->run("select cp.name as cpname, cp.idcourse_profile as idcourse_profile, c.course_name as cname, cl.name as clname from course_profile cp, course c, class cl where cp.course_id = c.idcourse and cp.class_id = cl.idclass and cp.staff_id = :sid", array(":sid" => $user->userid));
?>
<!-- 100% Box Grid Container: Start -->
<div class="grid_24">
<?php
	if(isset($flash['success'])) {
?>
	<!-- Success Notice: Start -->
	<div class="notice success">
		<p><?php echo $flash['success']; ?>.</p>
	</div>
	<!-- Success Notice: End -->
<?php
	}

	if(isset($flash['error'])) {
?>
	<!-- Error Notice: Start -->
	<div class="notice error">
		<p><?php echo $flash['error']; ?>.</p>
	</div>
	<!-- Error Notice: End -->

<?php
	}
	
	if(isset($flash['warning'])) {
?>
	<!-- Error Notice: Start -->
	<div class="notice warning">
		<p><?php echo $flash['warning']; ?>.</p>
	</div>
	<!-- Error Notice: End -->

<?php
		}
?>

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Course Profiles</h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content <?php if(count($course_profiles) < 1) echo "padding"; ?>">
	<?php
	
	if(count($course_profiles) > 0) {
	?>
	<form method="POST" action="<?php echo url_for('/staff/course_profile/batch/delete'); ?>">
	<input type="hidden" name="staff_id" value="<?php echo $user->userid; ?>" />
	<div id="listing">
	<!-- Course Profile Table Listing: Start -->
	<table class="sorting">
		<thead>
			<tr>
				<th class="checkers"><input type="checkbox" class="checkall" /></th>
				<th class="align_left">Title</th>
				<th class="align_left center">Class</th>
				<th class="align_left center">Course</th>
				<th class="align_left center tools">Tools</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach($course_profiles as $cp) {
		?>
			<tr>
				<th class="checkers"><input type="checkbox" name="course_profiles[<?php echo $cp['idcourse_profile']; ?>]"/></th>
				<td class="align_left"><?php echo $cp['cpname']; ?></td>
				<td class="align_left center"><?php echo $cp['clname']; ?></td>
				<td class="align_left center"><?php echo $cp['cname']; ?></td>
				<td class="align_left tools center">
					<a href="<?php echo url_for("/staff/course_profile/" . $cp['idcourse_profile'] . "/edit"); ?>" class="edit tip" title="edit">edit</a>
					<a href="<?php echo url_for("/staff/course_profile/" . $cp['idcourse_profile'] . "/delete"); ?>" class="delete tip" title="delete">delete</a>
				</td>
			</tr>
		<?php
			}
		?>
		</tbody>
	</table> 

	<div class="table_actions">
		<input type="checkbox" class="checkall" />

		<button class="left">Delete Selected</button>
	</div>
	</form>
	</div>
	<!-- Course Profile Listing: End -->	
	<?php
		} // End of Course Profile Listing Table
		else {
	?>
		<div class="field noline">
			<h6 class="noline">There are no Course profiles in your account. Please <a  href="<?php echo url_for('/staff/course_profile/add'); ?>">Add </a> them. </h6>
		</div>
	<?php
		}
	?>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->

<?php
	end_content_for();

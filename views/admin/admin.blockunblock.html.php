<?php

	$user = get_user();
	$db = $GLOBALS['db'];
	
	$staffs = $db->select("staff", "1=1 order by staff_id asc");
	$students = $db->select("student");
	
	content_for('body');
	
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

<!-- 100% Box Grid Container: Start -->
<div class="grid_24">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h2 class="icon frames"><?php echo get_text('BLOCK_UNBLOCK_USERS'); ?></h2>

		<!-- Tab Select: Start -->
		<ul class="sorting">
			<li><a href="#students_list" class="active"><?php echo get_text('STUDENT'); ?></a></li>
			<li><a href="#staffs_list"><?php echo get_text('STAFF'); ?></a></li>
		</ul>
		<!-- Tab Select: End -->
		
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content">
		<!-- Tabs: Start -->
		<div class="tabs">
			
			<div id="students_list">
			<form method="POST" action="<?php echo url_for('/admin/student/block'); ?>">
				<table class="sorting">
					<thead>
						<tr>
							<th class="checkers"><input type="checkbox" class="checkall" /></th>
							<th class="align_left">Register Number</th>
							<th class="align_left center">Name</th>
							<th class="align_left center">Year</th>
							<th class="align_left center">Semester</th>
							<th class="align_left center">Status</th>
							<th class="align_left center tools">Tools</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$i = 0; 
						foreach($students as $student) {
							if($i++ > 150) break;
					?>
						<tr>
							<th class="checkers"><input type="checkbox" name="student_profile[<?php echo $student['idstudent']; ?>]"/></th>
							<td class="align_left"><?php echo $student['idstudent']; ?></td>
							<td class="align_left center"><?php echo $student['name']; ?></td>
							<td class="align_left center"><?php echo $student['year']; ?></td>
							<td class="align_left center"><?php echo $student['current_Semester']; ?></td>
								<?php
									if($student['is_blocked']) {
								?>
							<td class="align_left center"><span class="icon stop"></span></td>
							<td class="align_left tools center">
								<a href="<?php echo url_for("/admin/student/" . $student['idstudent'] . "/unblock"); ?>" class="delete tip" title="<?php echo get_text('UNBLOCK'); ?>">edit</a>
							</td>
								<?php
									} else {
								?>
							<td class="align_left center"><span class="icon success"></span></td>
							<td class="align_left tools center">
								<a href="<?php echo url_for("/admin/student/" . $student['idstudent'] . "/block"); ?>" class="edit tip" title="<?php echo get_text('BLOCK'); ?>">delete</a>
							</td>
								<?php
									}
								?>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table>

				<div class="table_actions">
					<input type="checkbox" class="checkall" />
					
					<select name="operation" class="validate required">
						<option><?php echo get_text('CHOOSE_ACTION'); ?></option>
						<option value="block"><?php echo get_text('BLOCK'); ?></option>
						<option value="unblock"><?php echo get_text('UNBLOCK'); ?></option>
					</select>
					
					<button type="submit" class="left"><?php echo get_text('APPLY_SELECTED'); ?></button>
				</div>
			</form>
			</div>
			
			<div id="staffs_list">
			<form method="POST" action="<?php echo url_for('/admin/staff/block'); ?>">
				<table class="sorting">
					<thead>
						<tr>
							<th class="checkers"><input type="checkbox" class="checkall" /></th>
							<th class="align_left">Staff Code</th>
							<th class="align_left center">Name</th>
							<th class="align_left center">Designation</th>
							<th class="align_left center">EMail</th>
							<th class="align_left center">Status</th>
							<th class="align_left center tools">Tools</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$course_profiles = array();
						foreach($staffs as $staff) {
					?>
						<tr>
							<th class="checkers"><input type="checkbox" name="staff_profile[<?php echo $staff['idstaff']; ?>]"/></th>
							<td class="align_left"><?php echo $staff['staff_id']; ?></td>
							<td class="align_left"><?php echo $staff['name']; ?></td>
							<td class="align_left center"><?php echo $staff['designation']; ?></td>
							<td class="align_left center"><?php echo $staff['email']; ?></td>
							<?php
								if($staff['is_blocked']) {
							?>
							<td class="align_left center"><span class="icon stop"></span></td>
							<td class="align_left tools center">
								<a href="<?php echo url_for("/admin/staff/" . $staff['idstaff'] . "/unblock"); ?>" class="delete tip" title="<?php echo get_text('UNBLOCK'); ?>">"Unblock User</a>
							</td>
							<?php
								} else {
							?>
							<td class="align_left center"><span class="icon success"></span></td>
							<td class="align_left tools center">
								<a href="<?php echo url_for("/admin/staff/" . $staff['idstaff'] . "/block"); ?>" class="edit tip" title="<?php echo get_text('BLOCK'); ?>">Block User</a>
							</td>
							<?php
								}
							?>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table> 
				<div class="table_actions">
					<input type="checkbox" class="checkall" />
					
					<select name="operation" class="validate required">
						<option><?php echo get_text('CHOOSE_ACTION'); ?></option>
						<option value="block"><?php echo get_text('BLOCK'); ?></option>
						<option value="unblock"><?php echo get_text('UNBLOCK'); ?></option>
					</select>
					
					<button type="submit" class="left"><?php echo get_text('APPLY_SELECTED'); ?></button>
				</div>
			</form>
			</div>

		</div>
		<!-- Tabs Class: End -->
		
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->

<?php
	end_content_for();

	content_for('js');
?>
<script type="text/javascript" src="<?php echo url_for('/admin/js/'); ?>"></script>
<?php
	end_content_for();
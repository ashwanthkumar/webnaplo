<?php

	// Get the current user in the context
	$user = get_user();
	$db = $GLOBALS['db'];
	
	// Get list of all staff
	$staffs = Staff::search($db);
	// Get list of all students
	$students = Student::search($db);
	
	// Get the list of Course profiles with their lock status
	$locknunlock = LockUnLock::getList($db);

	content_for('body');
	
	// Re-initialize the LockNUnlock Status for all the course profiles
	// This is to be executed when setting up the system
	// @todo Find a way to automate this task. Probably set this up as the Cron job?
	// set_time_limit(0);
	// LockUnLock::initLockUnLock($db);
?>
<!-- 100% Box Grid Container: Start -->
<div class="grid_24">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames"><?php echo get_text('LOCK'); echo get_text('AND'); echo get_text('UNLOCK'); echo get_text('STATUS'); ?></h1>
	</div>
	<!-- Box Header: End -->
	
	
	<!-- Box Content: Start -->
	<div class="box_content">
				<table class="sorting">
					<thead>
						<tr>
							<th class="align_left center">SNO</th>
							<th class="align_left center tools">Course Profile</th>
							<th class="align_left center">CIA - I</th>
							<th class="align_left center">CIA - II</th>
							<th class="align_left center">CIA - III</th>
							<th class="align_left center">Assignment</th>
							<th class="align_left center">Attendance</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$i = 0; 
						foreach($locknunlock as $lu) {
							if($i++ > 150) break;
					?>
						<tr>
							<td class="align_left center"><?php echo $i; ?></td>
							<td class="align_left center">
								<?php
									echo $lu['name']; 
								?>
							</td>
							<td class="align_left center">
								<?php if($lu['c1'] == 0) {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/1/" . $lu['id'] . "/lock"); ?>" class="edit tip" title="<?php echo get_text('LOCK'); ?>">lock</a>
								<?php
									} else {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/1/" . $lu['id'] . "/unlock"); ?>" class="delete tip" title="<?php echo get_text('UNLOCK'); ?>">unlock</a>
								<?php
									}
								?>
							</td>
							<td class="align_left center">
								<?php if($lu['c2'] == 0) {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/2/" . $lu['id'] . "/lock"); ?>" class="edit tip" title="<?php echo get_text('LOCK'); ?>">lock</a>
								<?php
									} else {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/2/" . $lu['id'] . "/unlock"); ?>" class="delete tip" title="<?php echo get_text('UNLOCK'); ?>">unlock</a>
								<?php
									}
								?>
							</td>
							<td class="align_left center">
								<?php if($lu['c3'] == 0 ) {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/3/" . $lu['id'] . "/lock"); ?>" class="edit tip" title="<?php echo get_text('LOCK'); ?>">lock</a>
								<?php
									} else {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/3/" . $lu['id'] . "/unlock"); ?>" class="delete tip" title="<?php echo get_text('UNLOCK'); ?>">unlock</a>
								<?php
									}
								?>
							</td>
							<td class="align_left center">
								<?php if($lu['assignment'] == 0) {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/4/" . $lu['id'] . "/lock"); ?>" class="edit tip" title="<?php echo get_text('LOCK'); ?>">lock</a>
								<?php
									} else {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/4/" . $lu['id'] . "/unlock"); ?>" class="delete tip" title="<?php echo get_text('UNLOCK'); ?>">unlock</a>
								<?php
									}
								?>
							</td>
							<td class="align_left center">
								<?php if($lu['attendance'] = 0) {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/5/" . $lu['id'] . "/lock"); ?>" class="edit tip" title="<?php echo get_text('LOCK'); ?>">lock</a>
								<?php
									} else {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/5/" . $lu['id'] . "/unlock"); ?>" class="delete tip" title="<?php echo get_text('UNLOCK'); ?>">unlock</a>
								<?php
									}
								?>
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
<!-- 100% Box Grid Container: End -->

<?php
	end_content_for();

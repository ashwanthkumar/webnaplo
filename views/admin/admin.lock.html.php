<?php

	$user = get_user();
	$db = $GLOBALS['db'];
	
	$staffs = $db->select("staff", "1=1 order by staff_id asc");
	$students = $db->select("student");
	$locknunlock = $db->run("select cl.idclass as id, lu.assignment as assignment, lu.attendance as attendance, lu.cia_1 as c1, lu.cia_2 as c2, lu.cia_3 as c3, cl.name as name from lock_unlock lu, class cl where cl.idclass = lu.class_id");

	content_for('body');
	
	// Re-initialize the LockNUnlock Status for all the classes
	// set_time_limit(0);
	// LockUnLock::initLockUnLock($db);
?>
<!-- 100% Box Grid Container: Start -->
<div class="grid_24">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Lock &amp; Unlock Status</h1>
	</div>
	<!-- Box Header: End -->
	
	
	<!-- Box Content: Start -->
	<div class="box_content">
				<table class="sorting">
					<thead>
						<tr>
							<th class="align_left center">SNO</th>
							<th class="align_left center tools">Class</th>
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
								<a href="<?php echo url_for("/admin/lock_unlock/1/" . $lu['id'] . "/lock"); ?>" class="edit tip" title="Lock CIA I">lock</a>
								<?php
									} else {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/1/" . $lu['id'] . "/unlock"); ?>" class="delete tip" title="Unlock CIA I">unlock</a>
								<?php
									}
								?>
							</td>
							<td class="align_left center">
								<?php if($lu['c2'] == 0) {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/2/" . $lu['id'] . "/lock"); ?>" class="edit tip" title="Lock CIA II">lock</a>
								<?php
									} else {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/2/" . $lu['id'] . "/unlock"); ?>" class="delete tip" title="Unlock CIA II">unlock</a>
								<?php
									}
								?>
							</td>
							<td class="align_left center">
								<?php if($lu['c3'] == 0 ) {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/3/" . $lu['id'] . "/lock"); ?>" class="edit tip" title="Lock CIA III">lock</a>
								<?php
									} else {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/3/" . $lu['id'] . "/unlock"); ?>" class="delete tip" title="Unlock CIA III">unlock</a>
								<?php
									}
								?>
							</td>
							<td class="align_left center">
								<?php if($lu['assignment'] == 0) {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/4/" . $lu['id'] . "/lock"); ?>" class="edit tip" title="Lock Assignment">lock</a>
								<?php
									} else {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/4/" . $lu['id'] . "/unlock"); ?>" class="delete tip" title="Unlock Assignment">unlock</a>
								<?php
									}
								?>
							</td>
							<td class="align_left center">
								<?php if($lu['attendance'] = 0) {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/5/" . $lu['id'] . "/lock"); ?>" class="edit tip" title="Lock Attendance">lock</a>
								<?php
									} else {
								?>
								<a href="<?php echo url_for("/admin/lock_unlock/5/" . $lu['id'] . "/unlock"); ?>" class="delete tip" title="Unlock Attendance">unlock</a>
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
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
		
		<h1 class="icon frames"><?php echo get_text('POST_MARKS'); ?></h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content">	
		<div id="listing">
		<!-- Course Profile Table Listing: Start -->
		<table class="sorting">
			<thead>
				<tr>
					<th class="align_left center"><?php echo get_text('COURSE_PROFILE'); ?></th>
					<th class="align_left center"><?php echo get_text('COURSE'); ?></th>
					<th class="align_left center"><?php echo get_text('STUDENT_CONFIRMATION'); ?></th>
					<th class="align_left center tools"><?php echo get_text('TOOLS'); ?></th>
				</tr>
			</thead>
			<tbody>
		
			<?php 	
				$rand_counter = time();
				
				foreach($courseProfileList as $pa) {
						$lock_status = LockUnLock::getBlockStatus($pa['idcourse_profile'], $db);
						$lock_status = $lock_status[0];
			?>
				<tr>
					<td class="align_left center"><?php echo $pa['cpname']; ?></td>
					<td class="align_left center"><?php echo $pa['cname']; ?></td>
					<td class="align_left center">
					<?php
						if($pa['enable_confirm'] == 1) {
							// Enabled so show disable button
					?>
						<a href="#" onclick="disable_confirmation('<?php echo $pa['idcourse_profile']; ?>');" class="tip" title="Disable Student Confirmation"><span id="cp<?php echo $pa['idcourse_profile']; ?>" class="icon success dark">&nbsp;</span></a>
					<?php
						} else {
							// Disabled so show enable button
					?>
						<a href="#" onclick="enable_confirmation('<?php echo $pa['idcourse_profile']; ?>');"  class="tip" title="Enable Student Confirmation"><span id="cp<?php echo $pa['idcourse_profile']; ?>" class="icon error dark">&nbsp;</span></a>
					<?php
						}
					?>
					</td>
					<td class="align_left tools center">
					<?php
						
						$attendance_status = $lock_status['attendance'];
						if($attendance_status == 0) {
					?>
						<a onclick="window.open('<?php echo url_for('/staff/marks/' . $pa['idcourse_profile'] . '/popup'); ?>', 'mark_popup','status=0,height=650,width=1000');return false;" class="edit tip" title="Post Marks">post</a>
					<?php
						} else {
					?>
						Disabled
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
	</div>
	<!-- Box Content: End -->

	<div class="box_content padding">
		<div class="">
			<h3>General Instructions </h3>
			<ol>
				<li>To Post CIA / Assignment marks, select the corresponding mark type and enter the marks.  </li>
				<li>To Edit CIA / Assignment marks, select the corresponding mark type and click "Load Marks" </li>
				<li>If you have <b>"Disabled"</b> text instead of an icon for posting the marks, your ability to post has been locked. Please contact the System Administrator to unlock the respective course profile. </li>
			</ol>
		</div>
	</div>
	
</div>
<!-- 100% Box Grid Container: End -->

<script type="text/javascript">
	var _service_url = "<?php echo url_for('/staff/cia/enable_confirmation/'); ?>";
	var _url = window.location.href;
	function enable_confirmation(cpid) {
		$.post(_service_url + '/enable', { 'cp_id' : cpid }, function(data) {
			if(data.status === true) {
				// window.location.href = _url;
				var _span_id = "#cp" + cpid;
				$(_span_id).removeClass("error");
				$(_span_id).addClass("success");

				$(_span_id).parent().unbind('onclick');
				$(_span_id).parent().unbind('click');
				$(_span_id).parent().poshytip('update', 'Disable Student Confirmation');
				$(_span_id).parent().click(function() { disable_confirmation(cpid) });
			} else if(data.status === false) {
				alert(data.error);
			}

		});
	}
	
	function disable_confirmation(cpid) {
		$.post(_service_url + '/disable', { 'cp_id' : cpid }, function(data) {
			if(data.status === true) {
				// window.location.href = _url;
				var _span_id = "#cp" + cpid;
				$(_span_id).removeClass("success");
				$(_span_id).addClass("error");
				
				$(_span_id).parent().unbind('onclick');
				$(_span_id).parent().unbind('click');
				$(_span_id).parent().poshytip('update', 'Enable Student Confirmation');
				$(_span_id).parent().click(function() { enable_confirmation(cpid) });
			} else if(data.status === false) {
				alert(data.error);
			}
		});
	}
</script>
<?php
	end_content_for();
	

<?php 
	
	$db = $GLOBALS['db'];
	
	$user = get_user();
	
	$student = Student::load($user->userid, $db);
	
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

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames"><?php echo get_text('STUDENT_CIA_MARKS'); ?></h1>
	</div>
	<!-- Box Header: End -->
	
	
	<!-- Box Content: Start -->
	<div class="box_content">
		<table>
			<thead>
				<tr>
					<th class="align_left center"><?php echo get_text('COURSE'); ?></th>
					<th class="align_left center"> <?php echo get_text('_CIA'); ?> I</th>
					<th class="align_left center"> <?php echo get_text('_CIA'); ?> II</th>
					<th class="align_left center"> <?php echo get_text('_CIA'); ?> III</th>
					<th class="align_left center"> <?php echo get_text('ASSIGNMENT'); ?> </th>
					<th class="align_left center"> <?php echo get_text('TOTAL'); ?> </th>
					<th class="align_left center"> <?php echo get_text('CONFIRM'); ?>? </th>
				</tr>
			</thead>
			
			<tbody>
			<?php
			
				// Loop through all the Course Profiles of Student and display their marks
				$mark_data = $student->getMarks($db);

				foreach($mark_data as $student_marks) {
			?>
				<tr>
					<td class="left"><?php echo $student_marks['coursename']; ?> (<?php echo $student_marks['coursecode']; ?>)</td>
					<td class="align_left center"><?php 
						if(!is_null($student_marks['cia1'])) {
							echo $student_marks['cia1'] .  ' (' . (($student_marks['cia1']) * 0.4)  . ')';
						} else {
							echo 'N/A';
						}
					?></td>
					<td class="align_left center"><?php 
						if(!is_null($student_marks['cia2'])) {
							echo $student_marks['cia2'] .  ' (' . (($student_marks['cia2']) * 0.4)  . ')';
						} else {
							echo 'N/A';
						}
					?></td>
					<td class="align_left center"><?php 
						if(!is_null($student_marks['cia3'])) {
							echo $student_marks['cia3'] .  ' (' . (($student_marks['cia3']) * 0.4)  . ')';
						} else {
							echo 'N/A';
						}
					?></td>
					<td class="align_left center"><?php 
						if(!is_null($student_marks['assignment'])) {
							echo $student_marks['assignment'];
						} else {
							echo 'N/A';
						}
					?></td>
					<td>
					<?php
						// Calculate the Total Internals when the assignment mark is posted
						// Well this is a wild assumption, any better mechanism is acceptable
						// Refer Issue #25 to re-open the issue and provide your suggestion
						if(!is_null($student_marks['assignment'])) {
							// Assignment has been posted so we can now calculate the internals
							$cia_1 = $student_marks['cia1'];
							$cia_2 = $student_marks['cia2'];
							$cia_3 = $student_marks['cia3'];
							$assignment = $student_marks['assignment'];
							$internals = 0;
							
							$sort_array = array($cia_1,$cia_2, $cia_3);
							rsort($sort_array, SORT_NUMERIC);
							
							// Sum of best 2 CIAs and add the Assigment mark to it
							$internals = round ((($sort_array[0] + $sort_array[1]) * 0.4) + $assignment);
							
							echo $internals;
						} else {
							echo 'N/A';
						}
					?>
					</td>
					<td><?php
						if($student_marks['enable_confirm'] == 1) {
							if($student_marks['is_confirmed'] == 1) {
								// @TODO Implement this, part of Issue #25
						?>
							<span class="icon success title" title="Confirmed!">&nbsp; </span>
						<?php
							} else {
						?>
							<a href="<?php echo url_for('/student/cia/' . $student_marks['cp_id'] . '/confirm'); ?>" class="edit tip" title="Confirm!"><span class="icon success dark">&nbsp; </span></a>
						<?php
								// echo "Can Confirma";
							}
						} else {
						?>
							<span class="tip" title="Not Available Yet">N/A</span>
						<?php
						}
					?></td>
				</tr>
			<?php
				}
				// End of Looping through all the CIA marks
			?>
			</tbody>
		</table>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->
<?php
	end_content_for();

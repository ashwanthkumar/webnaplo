<?php 
	
	$db = $GLOBALS['db'];
	
	$user = get_user();
	
	$student = Student::load($user->userid, $db);
	
	content_for('body');
	
?>
<!-- 100% Box Grid Container: Start -->
<div class="grid_24">

	<!-- Box Header: Start -->
	<div class="box_top">
		
		<h1 class="icon frames">&nbsp;</h1>
		
	</div>
	<!-- Box Header: End -->
	
	
	<!-- Box Content: Start -->
	<div class="box_content">
		<table>
			<thead>
				<tr>
					<th>Course Profile</th>
					<th> I CIA </th>
					<th> II CIA </th>
					<th> III CIA </th>
					<th> Assignment </th>
				</tr>
			</thead>
			
			<tbody>
			<?php
			
				// Loop through all the Course Profiles of Student and display their marks
				$mark_data = $student->getMarks($db);
				foreach($mark_data as $student_marks) {
				// print_r($mark_data);
			?>
				<tr>
					<td><?php echo $student_marks['coursename']; ?>(<?php echo $student_marks['coursecode']; ?>)</td>
					<td><?php echo $student_marks['cia1']; ?> (<?php echo (($student_marks['cia1']) * 0.4); ?>)</td>
					<td><?php echo $student_marks['cia2']; ?> (<?php echo (($student_marks['cia2']) * 0.4); ?>)</td>
					<td><?php echo $student_marks['cia3']; ?> (<?php echo (($student_marks['cia3']) * 0.4); ?>)</td>
					<td><?php echo $student_marks['assignment']; ?></td>
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

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
				print_r($mark_data);
			?>
				<tr>
					<td>Name of Course</td>
					<td>50 (20)</td>
					<td>50 (20)</td>
					<td>50 (20)</td>
					<td>10</td>
				</tr>
			<?php
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

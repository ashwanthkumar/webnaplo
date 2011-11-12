<?php

	$db = $GLOBALS['db'];
	
	$user = get_user();
	content_for('body');
	
?>

<!-- 100% Box Grid Container: Start -->
<div class="grid_24">
	<!-- Box Header: Start -->
	<div class="box_top">
		
		<h1 class="icon frames">Course List</h1>
		
	</div>
	<!-- Box Header: End -->
	
	<?php
		$programmes = $db->run("select p.idprogramme as idprogramme, d.iddept as iddept, p.name as pname, d.name as dname, c.course_name as course_name, c.course_code as course_code, c.credits as credits from programme p, dept d, course c where c.programme_id = p.idprogramme and p.dept_id = d.iddept");
		
	?>
	<!-- Box Content: Start -->
	<div class="box_content ">
		<table class="sorting">
			<thead>
				<tr>
					<th class="align_left center">SNO</th>
					<th class="align_left center">Course Code </th>
					<th class="align_left center">Course Name </th>
					<th class="align_left center">Credits </th>
					<th class="align_left center">Programme </th>
					<th class="align_left center">Department</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$i = 0; 
				foreach($programmes as $programme) {
					if($i++ > 150) break;
			?>

				<tr>
					<td class="align_left center"><?php echo $i; ?></td>
					<td class="align_left center">
					<?php if($user->IsAdmin()): ?>
						<a href="<?php echo url_for('/admin/course/' . $programme['course_code'] . '/edit'); ?>">
					<?php endif; ?>
						<?php echo $programme['course_code']; ?>
					<?php if($user->IsAdmin()):?>
						</a>
					<?php endif;?>
					</td>
					<td class="align_left center"><?php echo $programme['course_name']; ?></td>
					<td class="align_left center"><?php echo $programme['credits']; ?></td>
					<td class="align_left center"><?php echo $programme['pname']; ?></td>
					<td class="align_left center"><?php echo $programme['dname']; ?></td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>

		<div class="table_actions">
			<button type="submit" onclick="window.open('<?php echo url_for('/' . $user->type .'/export/list/course'); ?>','pdfexplore','status');" class="left">Export as PDF</button>
		</div>
		
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->
<?php
	end_content_for(); 
?>
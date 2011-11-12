<?php

	$db = $GLOBALS['db'];
	$user = get_user();
	
	content_for('body');
?>

<!-- 100% Box Grid Container: Start -->
<div class="grid_24">
	<!-- Box Header: Start -->
	<div class="box_top">
		
		<h1 class="icon frames">Programme List</h1>
		
	</div>
	<!-- Box Header: End -->
	
	<?php
		$programmes = $db->run("select p.idprogramme as idprogramme, d.iddept as iddept, p.name as pname, d.name as dname from programme p, dept d where p.dept_id = d.iddept");
		
	?>
	<!-- Box Content: Start -->
	<div class="box_content ">
		<table class="sorting">
			<thead>
				<tr>
					<th class="align_left center">SNO</th>
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
					<a href="<?php echo url_for('/admin/programme/' . $programme['idprogramme'] . '/edit'); ?>">
					<?php endif; ?>
						<?php echo $programme['pname']; ?>
					<?php if($user->IsAdmin()):?>
						</a>
					<?php endif;?>
					</td>
					<td class="align_left center">
					<?php if($user->IsAdmin()): ?>					
						<a href="<?php echo url_for('/admin/programme/' . $programme['iddept'] . '/edit'); ?>">
					<?php endif;?>
						<?php echo $programme['dname']; ?>
					<?php if($user->IsAdmin()): ?>					
						</a>
					<?php endif;?>
					</td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>

		<div class="table_actions">
			<button type="submit" onclick="window.open('<?php echo url_for('/' . $user->type . '/export/list/programme'); ?>','pdfexplore','status');" class="left">Export as PDF</button>
		</div>
		
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->
<?php
	end_content_for(); 
?>
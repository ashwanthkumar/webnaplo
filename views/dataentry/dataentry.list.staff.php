<?php

	$db = $GLOBALS['db'];
	
	content_for('body');
?>

<!-- 100% Box Grid Container: Start -->
<div class="grid_24">
	<!-- Box Header: Start -->
	<div class="box_top">
		
		<h1 class="icon frames">Staff List</h1>
		
	</div>
	<!-- Box Header: End -->
	
	<?php
		$staffs = $db->select("staff");
	?>
	<!-- Box Content: Start -->
	<div class="box_content ">
		<table class="sorting">
			<thead>
				<tr>
					<th class="align_left">SNO</th>
					<th class="align_left center">Staff Id</th>
					<th class="align_left center">Name</th>
					<th class="align_left center">Designation</th>
					<th class="align_left center">Email</th>
					<th class="align_left center tools">Mobile</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$i = 0; 
				foreach($staffs as $staff) {
					if($i++ > 150) break;
			?>

				<tr>
					<td class="align_left"><?php echo $i; ?></td>
					<td class="align_left"><a href="<?php echo url_for('/dataentry/staff/' . $staff['idstaff'] . '/edit'); ?>"><?php echo $staff['staff_id']; ?></a></td>
					<td class="align_left center"><?php echo $staff['name']; ?></td>
					<td class="align_left center"><?php echo $staff['designation']; ?></td>
					<td class="align_left center"><a href="mailto:<?php echo $staff['email']; ?>"><?php echo $staff['email']; ?></a></td>
					<td class="align_left center"><?php echo $staff['mobile']; ?></td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>

		<div class="table_actions">
			<button type="submit" onclick="window.open('<?php echo url_for('/dataentry/export/list/staff'); ?>');" class="left">Export as PDF</button>
		</div>
		
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->
<?php
	end_content_for(); 
?>
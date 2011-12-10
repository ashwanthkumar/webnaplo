<?php

	$user = get_user();
	$db = $GLOBALS['db'];
	
	content_for('body');

	$change_day_order = Attendance::getChangeOrder($db);
	// print_r($change_day_order);
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

<!-- 75% Box Grid Container: Start -->
<div class="grid_18">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h2 class="icon frames"><?php echo get_text('CHANGEDAYORDER_TITLE'); ?></h2>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content">
			<form method="POST" action="<?php echo url_for('/admin/changedayorder/delete'); ?>">
				<table class="sorting">
					<thead>
						<tr>
							<th class="checkers"><input type="checkbox" class="checkall" /></th>
							<th class="align_left center">Holiday</th>
							<th class="align_left center">Compensation</th>
							<th class="align_left center">Day Order</th>
							<th class="align_left center tools">Tools</th>
						</tr>
					</thead>
					<tbody>
					<?php
						foreach($change_day_order as $new_day_order) {
					?>
						<tr>
							<th class="checkers"><input type="checkbox" name="change_day_order[<?php echo $new_day_order['idchangedayorder']; ?>]"/></th>
							<td class="align_left center"><?php echo date('D, d F Y', strtotime($new_day_order['holiday_date'])); ?></td>
							<td class="align_left center"><?php echo date('D, d F Y', strtotime($new_day_order['compensation_date'])); ?></td>
							<td class="align_left center"><?php echo $new_day_order['day_order'];; ?></td>
							<td class="align_left tools center">
								<a href="<?php echo url_for("/admin/changedayorder/" . $new_day_order['idchangedayorder'] . "/delete"); ?>" class="delete tip" title="<?php echo get_text('DELETE'); ?>">delete</a>
							</td>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table>

				<div class="table_actions">
					<input type="checkbox" class="checkall" />
					
					<button type="submit" class="left"><?php echo get_text('DELETE_SELECTED'); ?></button>
				</div>
			</form>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 75% Box Grid Container: End -->

<!-- 25% Box Grid Container: Start -->
<div class="grid_6">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h2 class="icon frames"><?php //echo get_text('ADD_CHANGEDAYORDER_TITLE'); ?>Add a new Rule</h2>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
	<?php
		/**
		 *	@TODO Still more advanced date handling mechanism can be used here. There is still a scope for improvement. 
		 *	Refer Issue #1. Re-open the Issue, if you can contribute. 
		 *
		 *	By @ashwanthkumar 10/12/2011
		 **/
	?>
			<form method="POST" action="<?php echo url_for('/admin/changedayorder/add'); ?>">
			<div class="field">
				<label class="left">Holiday </label>
				<input type="text" id="holiday_date" name="holiday_date" readonly='true' class='changedayorder_date' />

				<label class="left">Compensation </label>
				<input type="text" id="compensation_date" name="compensation_date" readonly='true' class='changedayorder_date' />
			
				<label class="left">Day Order </label>
				<select name="day_order" class="big  left" >
					<option value='1'>Monday </option>
					<option value='2'>Tuesday </option>
					<option value='3'>Wednesday </option>
					<option value='4'>Thursday </option>
					<option value='5'>Friday </option>
					<option value='6'>Saturday </option>
					<option value='7'>Sunday </option>
				</select>
			</div>
			
			<div class="field noline">
				<button class="align_left center" type="submit">New Rule</button>
			</div>
			</form>
	</div>
	<!-- Box Content: End -->
	<script type="text/javascript">
		$(document).ready(function() {
			$('.changedayorder_date').datepicker({
				dateFormat: 'dd-mm-yy'
			});
		});
	</script>
</div>
<!-- 25% Box Grid Container: End -->

<?php
	end_content_for();

	// Content for Javascript for this Admin Page
	content_for('js');
?>
<script type="text/javascript" src="<?php echo url_for('/admin/js/'); ?>"></script>
<?php
	end_content_for();


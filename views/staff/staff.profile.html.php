<?php

	$db = $GLOBALS['db'];
	
	$user = get_user();
	
	$staff = Staff::load($user->userid, $db);
	
	content_for('body');
?>
<!-- 75% Box Grid Container: Start -->
<div class="grid_18">
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
		
		<h1 class="icon frames">Staff Profile</h1>
		
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		<form method="POST" action="<?php echo url_for('/staff/profile/save'); ?>">
			<div class="field noline">
				<label class="left">Designation</label>
				<label class="nobold left nowidth big"><?php echo $staff->designation; ?></label>
			</div>
			<div class="field noline">
				<label class="left">Department Name</label>
				<label class="nobold left nowidth"><?php echo Department::getName($staff->dept_id, $db); ?></label>
			</div>
			<div class="field">
				<label class="left">Password</label>
				<label class="nobold left nowidth">
				<input type="password" name="password" id="password" />
				</label>
			</div>
			<div class="field noline">
				<label class="left">Staff ID</label>
				<label class="nobold left nowidth"><?php echo $staff->staff_id; ?></label>
				<input type="hidden" name="idstaff" id="idstaff" value="<?php echo $staff->idstaff; ?>" />
			</div>
			<div class="field noline">
				<label class="left">Name</label>
				<label class="nobold left nowidth"><?php echo $staff->name; ?></label>
			</div>
			<div class="field noline">
					<label class="left">Email ID</label>
					<label class="nobold left nowidth"><input type="text" name="email" id="email"  value="<?php echo $staff->email; ?>"class="big validate required" /></label>
			</div>
			<div class="field noline">
				<label class="left">Mobile No</label>
				<label class="nobold left nowidth"><input type="text" name="mobile" id="mobile" value = "<?php echo $staff->mobile; ?>" class="big validate required" /></label>
			</div>
			
			<div class="field">
				<label class="left">Address</label>
				<label class="nobold left nowidth"></label>
				 <textarea name="address" cols="4" style="width: 291px; height: 115px;"><?php echo $staff->address; ?></textarea>
			</div>
			
			<div class="field noline">
				<button type="submit"> Update </button>
				<button type="reset"> Reset </button>
			</div>
		</form>
	</div>
	<!-- Box Content: End -->
		
</div>
<!-- 75% Box Grid Container: End -->

<?php
	end_content_for();

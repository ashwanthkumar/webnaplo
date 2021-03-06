<?php

	$db = $GLOBALS['db'];
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
		
		<h1 class="icon frames">Add Staff</h1>
		
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		<form method="POST" action="<?php echo url_for('/dataentry/staff/add'); ?>">

		<div class="field noline">
			<label class="left">Designation</label>
			
			<label class="nobold left nowidth big">
				<select name="designation" id="select">
					<option value="AP-I">Assistant Professor - I</option>
					<option value="AP-II">Assistant Professor - II</option>
					<option value="AP-III">Assistant Professor - III</option>
					<option value="Professor">Professor</option>
				</select>
			</label>
		</div>
		<div class="field">
			<label class="left">Department Name</label>
			<label class="nobold left nowidth">
			<?php
				$d = $db->select("dept", "1=1 order by name asc");
			?>
				<select name="dept_id" id="select">
				<?php
					foreach($d as $dept) {
				?>
					<option value="<?php echo $dept['iddept']; ?>"><?php echo $dept['name']; ?></option>
				<?php
					}
				?>
				</select>
			</label>
		</div>
		<div class="field noline">
			<label class="left">Staff Id</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate tip-form" title="Unique Identifier for the Staff" name="staff_id" id="staffid" /></label>
		</div>
		<div class="field noline">
			<label class="left">Name</label>
			<label class="nobold left nowidth"><input type="text" title="Name of the Staff" class="required big validate tip-form" name="name" id="name" /></label>
		</div>

		
			<div class="field noline">
				<label class="left">Email Id</label>
				<label class="nobold left nowidth"><input type="text" name="email" id="email" title="EMail of th Staff" class="big validate required tip-form email" /></label>
		</div>
		<div class="field noline">
			<label class="left">Mobile No</label>
			<label class="nobold left nowidth"><input type="text" name="mobile" id="mobile" title="Mobile Number of the Staff" class="big validate required tip-form digits" /></label>
		</div>
		

		<!-- Textarea: Start -->	
		<div class="field">
			<label class="left">Address</label>
			<label class="nobold left nowidth"></label>
			 <textarea name="address" class="validate required tip-form" title="Address of the staff" cols="4" style="width: 291px; height: 115px;"></textarea>
		</div>
		<!-- Textarea: End -->
		
		<div class="field noline">
			<button type="submit"> Add </button>
			<button type="reset"> Reset </button>
		</div>
		</form>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->
<?php 
	end_content_for();

<?php
	content_for('body');
?>
<!-- InstanceBeginEditable name="EditRegion1" -->
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
		
		<h1 class="icon frames">&nbsp;</h1>
		
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
	<form method="POST" action="<?php echo url_for('/dataentry/department/edit'); ?>">
		<div class="field noline">
			<h1>EDIT DEPARTMENT </h1>
		</div>

		<div class="field">
			<label class="left">Department Name</label>
			<p>Load the value from the DB </p>
			<label class="nobold left nowidth">
				<select name="dept_FK" id="department">
					<option name="CSE">CSE</option>
					<option name="IT">IT</option>
					<option name="ECE">ECE</option>
					<option name="EEE">EEE</option>
					<option name="PHYSICS">PHYSICS</option>
				</select>
			</label>
		</div>
		<div class="field noline">
			<label class="left"> New Department Name</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate" name="deptname" id="name" /></label>
		</div>
		
		<div class="field noline">
			<button type="submit"> Submit</button>
			<button type="reset"> Reset </button>
		</div>
	</form>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->
<?php
	end_content_for();

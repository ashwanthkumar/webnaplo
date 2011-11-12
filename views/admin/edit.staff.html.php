<?php
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
?>

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">&nbsp;</h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		
	<form method="POST" action="<?php echo url_for('/dataentry/staff/edit'); ?>">
		<div class="field noline">
			<h1>EDIT STAFF </h1>
		</div>
		<div class="field noline">
			<label class="left">Designation</label>
			
			<label class="nobold left nowidth big">
				<select name="Programme_FK" id="select">
					<option name="AP-I">Assistant Professor - I</option>
					<option name="AP-II">Assistant Professor - II</option>
					<option name="AP-III">Assistant Professor - III</option>
					<option name="Professor">Professor</option>
				</select>
			</label>
		</div>
		<div class="field">
			<label class="left">Department Name</label>
			<label class="nobold left nowidth">
				<select name="dept_FK" id="select">
					<option name="CSE">CSE</option>
					<option name="IT">IT</option>
					<option name="ECE">ECE</option>
					<option name="EEE">EEE</option>
					<option name="PHYSICS">PHYSICS</option>
				</select>
			</label>
		</div>
		<div class="field noline">
			<label class="left">Old Staff Id</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate" name="staffid" id="oldstaffid" /></label>
		</div>
		<div class="field noline">
			<label class="left">Staff Id</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate" name="staffis" id="staffid" /></label>
		</div>
		<div class="field noline">
			<label class="left">Name</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate" name="Coursecode" id="name" /></label>
		</div>

		
		<div class="field noline">
			<label class="left">Email Id</label>
			<label class="nobold left nowidth"><input type="text" name="Credits" id="email"  class="big validate required" /></label>
		</div>
		<div class="field noline">
			<label class="left">Mobile No</label>
			<label class="nobold left nowidth"><input type="text" name="Credits" id="mobile"  class="big validate required" /></label>
		</div>
		

		<!-- Textarea: Start -->	
		<div class="field">
			<label class="left">Address</label>
			<label class="nobold left nowidth"></label>
			 <textarea cols="4" style="width: 291px; height: 115px;"></textarea>
		</div>
		<!-- Textarea: End -->
		
		<div class="field noline">
			<button type="submit"> Submit </button>
			<button type="reset"> Reset </button>
		</div>
		
	</form>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->
<?php
	end_content_for();
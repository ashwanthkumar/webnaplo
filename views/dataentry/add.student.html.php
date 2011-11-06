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
		
		<form method="POST" action="<?php echo url_for('/dataentry/student/add'); ?>">
		<div class="field noline">
			<h1>ADD STUDENT </h1>
		</div>
		
		<div class="field">
			<label class="left">Department Name</label>
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
		<div class="field">
			<label class="left">Programe Name</label>
			<label class="nobold left nowidth">
				<select name="Programme_FK" id="programme">
					<option name="btech">B. Tech IT</option>
					<option name="btech">B. Tech CSE</option>
					<option name="btech">B. Tech ECE</option>
					<option name="btech">B. Tech EEE</option>
					<option name="btech">B. Tech PHYSICS</option>
				</select>
			</label>
		</div>
		<div class="field">
			<label class="left">Section Name</label>
			<label class="nobold left nowidth">
				<select name="section_FK" id="section">
					<option name="A">A</option>
					<option name="B">B</option>
				</select>
			</label>
		</div>
		
		<div class="field ">
			<label class="left">Year</label>
			<label class="nobold left nowidth">
				<select name="year" id="year">
					<option> I</option>
					<option>II</option>
					<option>III</option>
					<option>IV</option>
				</select>
			</label>
		</div>
		
		<div class="field noline">
			<label class="left">Register No</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate" name="name" id="regno" /></label>
		</div>
		<div class="field noline">
			<label class="left">Name</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate" name="name" id="name" /></label>
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
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
	<form method="POST" action="<?php echo url_for('/dataentry/course/add'); ?>">
		<div class="field noline">
			<h1>ADD COURSE </h1>
		</div>

		<div class="field noline">
			<label class="left">Course Code</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate" name="coursecode" id="coursecode" /></label>
		</div>

		<div class="field noline">
			<label class="left">Course Name</label>
			<label class="nobold left nowidth"><input type="text" name="coursename"  class="big validate required" id="coursename" /></label>
		</div>

		<div class="field noline">
			<label class="left">Credits</label>
			<label class="nobold left nowidth"><input type="text" name="credits" id="credits"  class="big validate required" /></label>
		</div>

		<div class="field">
			<label class="left">Programe Name</label>
			<label class="nobold left nowidth">
				<select name="programe" id="select">
					<option name="btech">B. Tech IT</option>
					<option name="btech">B. Tech CSE</option>
					<option name="btech">B. Tech ECE</option>
					<option name="btech">B. Tech EEE</option>
					<option name="btech">B. Tech PHYSICS</option>
				</select>
			</label>
		</div>
		
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
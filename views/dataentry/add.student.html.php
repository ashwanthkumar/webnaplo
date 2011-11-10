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
		
		<h1 class="icon frames">Add a new Student</h1>
		
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		
		<form method="POST" action="<?php echo url_for('/dataentry/student/add'); ?>">
<!--		
	Commented this out for future implementation
		<div class="field">
			<label class="left">Department Name</label>
			<label class="nobold left nowidth">
			<?php
				// $d = $db->select("dept");
			?>
				<select name="dept_id" id="department">
				<?php
					// foreach($d as $dept) {
				?>
					<option value="<?php echo $dept['iddept']; ?>"><?php echo $dept['name']; ?></option>
				<?php
					// }
				?>
				</select>
			</label>
		</div>
		<div class="field">
			<label class="left">Programe Name</label>
			<label class="nobold left nowidth">
			<?php
				// $p = $db->select('programme'); 
			?>
				<select name="programme_id" id="programme" disabled="disabled">
				<?php
					// foreach($p as $pgm) {
				?>
					<option value="<?php echo $pgm['idprogramme']; ?>"><?php echo $pgm['name'] ;?></option>
				<?php
					// }
				?>
				</select>
			</label>
		</div>
-->
		<div class="field">
			<label class="left">Section Name</label>
			<label class="nobold left nowidth">
			<?php
				$class = $db->select('class');
			?>
				<select name="class_id" id="class">
				<?php
					foreach($class as $c) {
				?>
					<option value="<?php echo $c['idclass']; ?>"><?php echo $c['name'] ;?></option>
				<?php
					}
				?>
				</select>
			</label>
		</div>
		
		<div class="field ">
			<label class="left">Year</label>
			<label class="nobold left nowidth">
				<select name="year" id="year">
					<option value="1">I</option>
					<option value="2">II</option>
					<option value="3">III</option>
					<option value="4">IV</option>
					<option value="5">V</option>
				</select>
			</label>
		</div>
		
		<div class="field noline">
			<label class="left">Register No</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate digits" name="idstudent" id="regno" /></label>
		</div>
		
		<div class="field noline">
			<label class="left">Name</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate" name="name" id="name" /></label>
		</div>

		<div class="field noline">
			<label class="left">Email Id</label>
			<label class="nobold left nowidth"><input type="text" name="email" id="email"  class="big validate required tip-form" title="Mobile number of the student"/></label>
		</div>
		
		<div class="field noline">
			<label class="left">Mobile No</label>
			<label class="nobold left nowidth"><input type="text" name="mobile" id="mobile"  class="big validate required digits min=6000000000 max=9999999999 tip-form" title="Mobile number of the student"/></label>
		</div>
		

		<!-- Textarea: Start -->	
		<div class="field">
			<label class="left">Address</label>
			<label class="nobold left nowidth "></label>
			 <textarea name="address" cols="4" style="width: 291px; height: 115px;" class="validate required"></textarea>
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
	
	content_for('javascript_libs');
		// require('dataentry.js.php');
	end_content_for('javascript_libs');
?>
	
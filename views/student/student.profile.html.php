<?php
	// Get the user of the application
	$user = get_user();

	// Getting the PDO Handler
	$db = $GLOBALS['db'];
	
	$stud = Student::load($user->userid, $db);
	
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
		<div class="field noline">
		<h1 class="icon frames">Student Profile</h1>
		</div>
		
	</div>
	<!-- Box Header: End -->
	
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
	<form method="POST" action="<?php echo url_for('/student/profile/update'); ?>">
		<div class="field noline">
			<label class="left">Register No</label>
			<label class="nobold left nowidth"><?php echo $stud->idstudent; ?></label>
			<input type="hidden" name="idstudent" id="idstudent" value="<?php echo $stud->idstudent; ?>" />
		</div>
		
		<div class="field noline">
			<label class="left">Name</label>
			<label class="nobold left nowidth"><?php echo $stud->name; ?></label>
			<input type="hidden" name="name" id="name" value="<?php echo $stud->name; ?>" />
		</div>

		<div class="field noline">
				<label class="left">Email Id</label>
				<label class="nobold left nowidth"><input type="text" name="email" id="email"  value="<?php echo $stud->email; ?>" class="big validate required email tip-form" title="EMail ID of the student"/></label>
		</div>

		<div class="field noline">
			<label class="left">Mobile No</label>
			<label class="nobold left nowidth"><input type="text" name="mobile" id="mobile"  value="<?php echo $stud->mobile; ?>" class="big validate required digits tip-form" title="Mobile number of the Student" /></label>
		</div>
		
		<?php
			// Get more information about the student
			$dept = $stud->getMore($db);
		?>
		<div class="field noline">
			<label class="left">Department Name</label>
			<label class="nobold left nowidth"><?php echo $dept['dname']; ?></label>
			<input type="hidden" name="iddept" value="<?php echo $dept['iddept']; ?>" />
		</div>

		<div class="field noline">
			<label class="left">Programme Name</label>
			<label class="nobold left nowidth"><?php echo $dept['pname']; ?></label>
			<input type="hidden" name="idprogramme" value="<?php echo $dept['idprogramme']; ?>" />
		</div>

		<div class="field noline">
			<label class="left">Section Name</label>
			<label class="nobold left nowidth"><?php echo $dept['cname']; ?></label>
			<input type="hidden" name="class_id" value="<?php echo $dept['idclass']; ?>" />
		</div>
		
		<div class="field noline">
			<label class="left">Year</label>
			<label class="nobold left nowidth"><?php echo $stud->year; ?></label>
		</div>

		<div class="field">
			<label class="left">Address</label>
			<label class="nobold left nowidth"></label>
			 <textarea cols="4" style="width: 291px; height: 115px;" class="tip-form validate" name="address" title="Address of the Student"><?php echo $stud->address; ?></textarea>
		</div>
		
		<div class="field noline">
			<button type="submit">Update</button>
			<button type="reset"> Reset </button>
		</div>
		</form>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->
<?php
	end_content_for();


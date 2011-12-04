<?php
	// Get the user of the application
	$user = get_user();

	// Getting the PDO Handler
	$db = $GLOBALS['db'];
	
	$stud = $db->select("staff", "idstaff = :sid", array(":sid" => $user->userid));
	$stud = $stud[0];
	
	// Edit Mode for re-using the template? 
	$edit_mode = isset($edit_me) ? true : false;
	if($edit_mode) {
		$course_profile = $db->run("select cp.course_id as course_id, cp.syllabus as syllabus, cp.name as cpname, c.course_name, c.course_code from course_profile cp, course c where cp.idcourse_profile = :cip and cp.course_id = c.idcourse and cp.staff_id = :sid", array(":cip" => $edit_me, ":sid" => $user->userid));
		
		
		
		if(is_object($course_profile) && get_class($course_profile) == "PDOException" or count($course_profile) < 1) {
			// redirect("/staff/course_profile/view");
			halt($course_profile->getMessage());
		}
		
		// Probably $course_profile is a valid resource
		$course_profile = $course_profile[0];
	}

	// Render Page Starts
	content_for('body');
?>
<!-- Having a universal form for the entire page -->
<form method="post" action="<?php if(!$edit_mode) echo url_for('/staff/course_profile/create'); else echo url_for('/staff/course_profile/edit'); ?>">

<div class="grid_18">
</div>
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
<div class="grid_9">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Create Course Profile </h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		<?php
			if($edit_mode) :
		?>
			<input type="hidden" name="idcourse_profile" value="<?php echo $edit_me; ?>" />
		<?php
			endif;
		?>
		
		<div class="field noline">
			<label class="left">Course</label>
			<label class="nobold left nowidth">
				<select name="course_id" id="course_id">
				<?php
					$courses = $db->select("course");
					
					foreach($courses as $d) {
				?>
					<option value="<?php echo $d['idcourse']; ?>" <?php if($edit_mode && $course_profile['course_id'] == $d['idcourse']) echo "selected='selected'"; ?>><?php echo $d['course_name'] ;?> (<?php echo $d['course_code']; ?>)</option>
				<?php
					}
				?>
				</select>
			</label>
		</div>
		<div class="field noline">
			<label class="left"> Name</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate tip-form" title="Name of the course profile" name="name" id="name" <?php if($edit_mode) echo "value='" . $course_profile['cpname'] . "'"; ?>/></label>
			<input type="hidden" name="staff_id" value="<?php echo $user->userid; ?>" id="staffid" />
		</div>

		<div class="field noline">
			<label class="left"> Syllabus</label>
			<label class="nobold left nowidth"><textarea class="big validate tip-form" name="syllabus" title="Copy &amp; Paste the syllabus" id="syllabus"> <?php if($edit_mode) echo $course_profile['syllabus']; ?></textarea></label>
		</div>
		
		<div class="field noline">
			<button type="submit"> <?php echo ($edit_mode) ? "Update" : "Add" ; ?> </button>
			<button type="button" onclick="window.location = '<?php echo $_SERVER['HTTP_REFERER']; ?>';"> Cancel </button>
		</div>
	</div>
	<!-- Box Content: End -->
	
</div>

<!-- Right Pane for Student List -->
<div class="grid_9">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Select Students</h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		
		<?php
			if($edit_mode) {
				// Display selection module only if the course is in edit mode
		?>
			<p>You should see a text box and Add button, followed by ordered list of students as Student Name (RegNo) with (X) next to it for deletion. Just make sure all this is done via AJAX and hence its live </p>
		<?php
			} else {
				// Show message to save the course profile
		?>
			<div class="field">
				<p>Please SAVE the course profile before adding the students. </p> 
				<p>Plan goes like this, we start off with creation of Course Profile and then add students to a particular course profile. </p>
			</div>
		<?php
			}
		?>
	</div>
	<!-- Box Content: End -->
	
</div>

</form>
<?php
	end_content_for();

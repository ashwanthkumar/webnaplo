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
		$course_profile = $db->run("select cp.course_id as course_id, cp.class_id as class_id, cp.name as cpname, cl.name as clname, c.course_name, c.course_code from course_profile cp, course c, class cl where cp.idcourse_profile = :cip and cp.class_id = cl.idclass and cp.course_id = c.idcourse and cp.staff_id = :sid", array(":cip" => $edit_me, ":sid" => $user->userid));
		
		
		
		if(is_object($course_profile) && get_class($course_profile) == "PDOException" or count($course_profile) < 1) {
			// redirect("/staff/course_profile/view");
			print_r($course_profile);
		}
		
		// Probably $course_profile is a valid resource
		$course_profile = $course_profile[0];
	}

	// Render Page Starts
	content_for('body');
?>
<!-- 100% Box Grid Container: Start -->
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
		<h1 class="icon frames">&nbsp;</h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		<form method="post" action="<?php if(!$edit_mode) echo url_for('/staff/course_profile/create'); else echo url_for('/staff/course_profile/edit'); ?>">
		<div class="field noline">
			<h1><?php echo ($edit_mode) ? "Editing " . $course_profile['cpname'] : "Course Profile"; ?> </h1>
		</div>
		
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
		<div class="field ">
			<label class="left">Class</label>
			<label class="nobold left nowidth">
				<select name="class_id" id="select">
				<?php 
					$class = $db->select("class");
					
					foreach($class as $c) {
				?>
					<option value="<?php echo $c['idclass']; ?>" <?php if($edit_mode && $course_profile['class_id'] == $c['idclass']) echo "selected='selected'"; ?>><?php echo $c['name'] ;?></option>
				<?php
					}
				?>
				</select>
			</label>
		</div>

		<div class="field noline">
			<label class="left"> Name</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate tip-form" name="name" id="name" <?php if($edit_mode) echo "value='" . $course_profile['cpname'] . "'"; ?>/></label>
			<label class="nobold left nowidth"><input type="hidden" name="staff_id" value="<?php echo $user->userid; ?>" id="staffid" /></label>
		</div>
		
		<div class="field noline">
			<button type="submit"> <?php echo ($edit_mode) ? "Update" : "Add" ; ?> </button>
			<button type="reset"> Reset </button>
			<button type="button" onclick="window.location = '<?php echo $_SERVER['HTTP_REFERER']; ?>';"> Cancel </button>
		</div>
		</form>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->

<?php
	end_content_for();

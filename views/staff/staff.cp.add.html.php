<?php
	// Get the user of the application
	$user = get_user();

	// Getting the PDO Handler
	$db = $GLOBALS['db'];

	$staff = Staff::load($user->userid, $db);
	
	// Edit Mode for re-using the template? 
	$edit_mode = isset($edit_me) ? true : false;
	if($edit_mode) {
		$course_profile = $staff->getCourseProfile($edit_me, $db);
		
		// Leave the page in case of an error
		if(!$course_profile) {
			flash('error', "There seems to be an error in editing the Course Profile");
			return redirect("/staff/course_profile");
		}
	}

	// Render Page Starts
	content_for('body');
?>
<!-- Having a universal form for the entire page -->
<form method="post" action="<?php if(!$edit_mode) echo url_for('/staff/course_profile/create'); else echo url_for('/staff/course_profile/edit'); ?>">

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
</div>

<div class="grid_9">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Course Profile Management </h1>
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
					$courses = Course::search($db);
					
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
			<script type="text/javascript">
				var add_service_url = "<?php echo url_for('/staff/course_profile/' . $edit_me . '/ajax/addstudent'); ?>";
				var del_service_url = "<?php echo url_for('/staff/course_profile/' . $edit_me . '/ajax/delstudent'); ?>";
				
				/**
				 *	Add the Student to course Profile via AJAX
				 **/
				function addStudentToCourseProfile() {
					var student_register_number = $('#students_id').val();
					$.post(add_service_url, {'studentid' : student_register_number}, function(d) {
						if(d != "false") {
							// Currently reload the page instead of fancy AJAX style adder. 
							// Issue #21 is open for fixers who wish to contribute
							window.location.href=window.location.href;
							/**
							 *	Following code is commented out to be fixed at Issue #21, please fix the changes and send in a Pull Request
							 *	if interested.
							 **/
							 /**
								// Iterate through all the students who were added
								$.each(d, function(index, value) {
									$("#studentsofcourseprofile").append('<li data="' + value + '">' + value + ' (<a data="' + value + '" href="#" onclick="javascript:deleteStudent(' + value + ', $(this));">X</a>)</li>');
								});
								$('#students_id').val('');
								// Sort the values of the student register number
								$('ol#studentsofcourseprofile>li').tsort('a[data]', {attr: 'data'});
							 **/
						} else {
							// Invalid Student Register Number
							alert("Invalid Student Register Number / Student Already added. ");
						}
					});
				}

				/**
				 *	Delete Student via AJAX
				 **/
				function deleteStudent(sid, element) {
					if(confirm('Do you want to remove the ' + sid + ' from your Course Profile?')) {
						$.post(del_service_url, {'studentid' : sid }, function(d) {
							if(d != "false") {
								element.parent().remove();
								$('ol#studentsofcourseprofile>li').tsort();
							} else {
								alert('Invalid Operation. Try again later.');
							}
						});
					}
				}
			</script>
			<div class="field">
				<p>Enter the Register numbers of the student who belong to your <strong><?php echo $course_profile['coursename']; ?></strong> class. </p>
			</div>
			<input type="text" name="students_id" id="students_id" class="small" />
			<button type="button" onclick="javascript:addStudentToCourseProfile();">Add Student </button>

			<ol id="studentsofcourseprofile">
			<?php
				// Initially display the list of students attached to this course profile
				$cp_object =  CourseProfile::load($edit_me, $db);
				$stud_list = $cp_object->getStudents($db);
				
				foreach($stud_list as $student) echo '<li data="' . $student['idstudent'] . '">' . $student['idstudent'] . ' (<a data="'. $student['idstudent'] .'" href="#" onclick="javascript:deleteStudent(' . $student['idstudent'] . ', $(this));">X</a>)</li>';
			?>
			</ol>
		<?php
			} else {
				// Show message to save the course profile
		?>
			<div class="field">
				<p>Please SAVE the course profile before adding the students. </p> 
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


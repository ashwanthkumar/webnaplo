<?php

	// Get the current user from the application
	$user = get_user();

	// Get the PDO handle
	$db = $GLOBALS['db'];

	$staff = Staff::load($user->userid, $db);
	
	if(!$staff) {
		// Seems like the user does not exist, automatically logout the user
		return redirect('/user/logout');
	}
	
	// Get the current Course PRofile information
	$course_profile = CourseProfile::load($cpid, $db);

	// Marker for the Timetable display
	content_for('body'); 
?>

<form method="POST" action="<?php echo url_for('/staff/ciamark/save'); ?>" id="ciaMarkEditor">
<input type="hidden" name="course_profile" id="course_profile" value="<?php echo $course_profile->idcourse_profile; ?>" />
<!-- Begin - Control Section for Attendance -->
<div class="grid_24">
<?php
	if(isset($flash['success'])) {
?>
<div class="notice success">
	<p><?php echo $flash['success']; ?></p>
</div>
<?php
	} else if (isset($flash['error'])) {
?>
<div class="notice error">
	<p><?php echo $flash['error']; ?></p>
</div>
<?php
	}
?>
	<div class="box_top" style="padding-top: -100px;">
		<h1 class="icon frames center">Post CIA Marks for <?php echo $course_profile->name ; ?></h1>
	</div>

	<div class="box_content padding">
		<!-- Display date on the left -->
		<div class="left">
			<p>
				Post Mark for: 
					<?php
						$lock_status = LockUnLock::getBlockStatus($course_profile->idcourse_profile, $db);
						$lock_status = $lock_status[0];
					
						// Do all the processing regarding the locked and unlocked values of the course profile
						$is_all_locked = ($lock_status['cia_1'] == 1 && $lock_status['cia_2'] == 1 && $lock_status['cia_3'] == 1 && $lock_status['assignment'] == 1) ? true : false;
						
						$is_cia1_locked = ($lock_status['cia_1'] == 1) ? true : false;
						$is_cia2_locked = ($lock_status['cia_2'] == 1) ? true : false;
						$is_cia3_locked = ($lock_status['cia_3'] == 1) ? true : false;
					?>
						<select name="cia_type" id="cia_type" <?php if($is_all_locked) echo 'disabled="disabled"'; ?> >
							<option value="cia_1" <?php echo isItemSelected($lock_status['cia_1']) ;?> >I CIA </option>
							<option value="cia_2" <?php echo isItemSelected($lock_status['cia_2'], $is_cia1_locked);?> >II CIA </option>
							<option value="cia_3" <?php echo isItemSelected($lock_status['cia_3'], $is_cia2_locked);?> >III CIA </option>
							<option value="assignment" <?php echo isItemSelected($lock_status['assignment'], $is_cia3_locked); ?> ><?php echo get_text('ASSIGNMENT'); ?> </option>
						</select>
			</p>
		</div>
		
		<div class="right">
			<?php
				if(!$is_all_locked) {
			?>
			<button type="button" onclick="loadData();">Load Marks</button>
			<button type="button" onclick="validate();">Post Marks</button>
			<button type="button" onclick="if(confirm('Do you wish to close?')) window.close();">Close</button>
			<script type="text/javascript">
				/**
				 *	Load all the marks for the given exam type
				 **/
				function loadData() {
					var markData;

					$.blockUI({ css: { 
						border: 'none', 
						padding: '15px', 
						backgroundColor: '#000', 
						'-webkit-border-radius': '10px', 
						'-moz-border-radius': '10px', 
						opacity: 1, 
						color: '#fff' 
					} }); 
					
					$.post("<?php echo url_for('/staff/ciamarks/load/ajax'); ?>", {
							'mark_type' : $("#cia_type").val(),
							"cpid" : $("#course_profile").val()
						}, 
						function(data) {
							markData = data;
							if(data.status == false) {
								alert(data.error);
								return;
							}
							
							$.each(data.marks, function(index, value) {
								if(value == null) value = 0;
								$("#" + index).val(value);
							});
							
							$.unblockUI();
						   $.growlUI('Notification', 'All student marks have been loaded.'); 
					});
				}
				
				/**
				 *	Custom mark text value validation function
				 *
				 *	@TODO Currently it checks only if the values are entered are not. Need to add digit only validation.
				 **/
				function validate() {
					// Get all the elements whose value is not entered
					var textElementsForValidation = $(':[type=text]').filter(function() {
						return ($(this).val().length < 1);
					});
					
					// Check if there are no error text values, even if there is one. Do not submit
					if(textElementsForValidation.length != 0) {
						alert('Have you entered all the marks?');
						
						$.each(textElementsForValidation, function(index, value) {
							$(value).removeClass('validate_success');
							$(value).addClass('validate_error');
							$(value).change(function() {
								if($(this).val().length > 0) {
									$(this).removeClass('validate_error');
									$(this).addClass('validate_success');
								} else {
									$(this).addClass('validate_error');
									$(this).removeClass('validate_success');
								}
							});
						});
					} else {
						$('form').submit();
					}
				}
			</script>
			<?php
				} else {
			?>
			<button type="button" onclick="window.close();">Please Exit Away! </button>
			<?php
				}
			?>
		</div>
		
	</div>
</div>
<!-- End - Control Section for Attendance -->

<?php
	
	// Get the list of students
	$student_list = $course_profile->getStudents($db);
	
	// Get the total count of students
	$stud = count($student_list);
	$first_limit =  round((int)$stud / 2, 0, PHP_ROUND_HALF_UP);
?>
<!-- Start of universal page form for the attendance -->
<div class="grid_12">
	<div class="box_top" style="padding-top: -100px;">
		<h1 class="icon frames center">First Half of Students in <?php echo $course_profile->name; ?></h1>
	</div>

	<div class="box_content padding">
	<!-- Left panel of the list of students -->
	<ol>
	<?php
		$studCounter = 0;
		for(; $studCounter < $first_limit; $studCounter++) {
			echo "<li class='field'><div class='align_left'>" . $student_list[$studCounter]['name'] . " (" . $student_list[$studCounter]['idstudent'] . ") &nbsp;";
			echo "<input type='text' class='verysmall align_left right' id=\"". $student_list[$studCounter]['idstudent'] . "\" name='student[" . $student_list[$studCounter]['idstudent'] . "]' checked='checked' /></li>";	
		}
	?>
	</ol>
	</div>
</div>
<!-- End of First Half of Students -->

<!-- Begin - Second Half of Students -->
<div class="grid_12">
	<div class="box_top" style="padding-top: -100px;">
		<h1 class="icon frames center">Second Half of Students in <?php echo $course_profile->name; ?></h1>
	</div>

	<div class="box_content padding">
	<!-- Left panel of the list of students -->
	<ol start="<?php echo $studCounter + 1; ?>">
	<?php
		for(; $studCounter < $stud; $studCounter++) {
			echo "<li class='field'><span class='align_left'>" . $student_list[$studCounter]['name'] . " (" . $student_list[$studCounter]['idstudent'] . ") </span>&nbsp;";
			echo "<input type='text' class='verysmall align_left right' id=\"". $student_list[$studCounter]['idstudent'] . "\" name='student[" . $student_list[$studCounter]['idstudent'] . "]' checked='checked' /></li>";	
		}
	?>
	</ol>
	</div>
</div>
<!-- End - Second Half of Students -->
</form>
<!-- End of universal page form for the attendance -->

<?php
	end_content_for();

	/**
	 *	Nifty utility function that enables or disables the items in the dropdown
	 **/
	function isItemSelected($cia_item, $previous_cia = true) {
			if($cia_item == 1) { 
				return "disabled='disabled'";	// Is this item locked? 
			} else {
				if($previous_cia) 
					return "selected='selected'";	// If the previous Item is locked, select this item
				else return "";	// Empty String
			}
	}

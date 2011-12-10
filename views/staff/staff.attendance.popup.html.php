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

<form method="POST" action="<?php echo url_for('/staff/attendance/save'); ?>" id="timetableEditor">
<input type="hidden" name="course_profile" value="<?php echo $course_profile->idcourse_profile; ?>" />
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
		<h1 class="icon frames center">Post Attendance for <?php echo $course_profile->name ; ?></h1>
	</div>

	<div class="box_content padding">
		<!-- Display date on the left -->
		<div class="left">
			<p>
				Date for Attendance: 
				<input type="text" id="date_selector" name="date_selector" readonly="true" /> 

				<select id="timeslots" name="hour_of_day">
				</select>
			</p>
		</div>
		
		<div class="right">
			<button type="button" onclick="if($('#date_selector').val().length > 0) $('form').submit(); else alert('Please enter a Date to post attendance?');">Post Attendance</button>
			<button type="button" onclick="if(confirm('Do you wish to cancel?')) window.close();">Cancel</button>
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
			echo "<li>" . $student_list[$studCounter]['name'] . " (" . $student_list[$studCounter]['idstudent'] . ")";
			echo "<input type='hidden' name='student[" . $student_list[$studCounter]['idstudent'] . "]' value='false' />";
			echo "<input type='checkbox' class='attendance' name='student[" . $student_list[$studCounter]['idstudent'] . "]' checked='checked' /></li>";
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
			echo "<li>" . $student_list[$studCounter]['name'] . " (" . $student_list[$studCounter]['idstudent'] . ")";
			echo "<input type='hidden' name='student[" . $student_list[$studCounter]['idstudent'] . "]' value='false' />";
			echo "<input type='checkbox' class='attendance' name='student[" . $student_list[$studCounter]['idstudent'] . "]' checked='checked' /></li>";	
		}
	?>
	</ol>
	</div>
</div>
<!-- End - Second Half of Students -->
</form>
<!-- End of universal page form for the attendance -->

<?php
	
	// Collection of Valid days_of_week for the given Course Profile
	$days_of_week = Attendance::getValidDaysForCourseProfile($cpid, $db);
	$echo_days = json_encode($days_of_week);
	
	// Copied from staff.timetable.popup.html
	$timeslots = array(1 => "07.30 - 08.40", "08.40 - 09.30", "09.30 - 10.20", "10.20 - 11.10", "10.40 - 11.30", "11.30 - 12.20", "12.20 - 13.10", "13.10 - 14.00", "14.10 - 15.00", "15.00 - 15.50", "16.00 - 16.50", "16.50 - 17.40", "17.40 - 18.30");
?>
<script type="text/javascript">
	var days_of_week = $.parseJSON('<?php echo $echo_days; ?>');
	var hours_of_day = $.parseJSON('<?php echo json_encode($timeslots); ?>');
	var ignored_days = $.parseJSON('<?php echo json_encode(Attendance::getIgnoredDays($cpid, $db)); ?>');
	var ignored_dates = new Array;
	
	var change_day_order_url = "<?php echo url_for('/staff/changeorder/ajax'); ?>";
	// Object that is fetched via AJAX
	var change_day_order;
	// List of compensation holidays
	var change_holiday = new Array;
	// List of compensation days for the holidays
	var change_compensation_day = new Array;
	/**
	 *	Contains the Object in the following form
	 *
	 *	var change_compensation_hour = {
	 *		componensation_date: day_order
	 *	}
	 **/
	var change_compensation_order = new Object;
	// Define an object that has all the required properties in { compensation: holiday }
	var change_day_object = new Object;
	
	$(document).ready(function() {
		// Populate the Timeslots via Javascript -- Vetti Scene than :P
		for(var time in hours_of_day) {
			$("#timeslots").append('<option value="' + time + '">' + hours_of_day[time] + '</option>');
		}

		// Calculate the IgnoredDates
		for(var ignored_object in ignored_days) {
			var date_to_insert = $.datepicker.formatDate('dd-mm-yy', new Date(ignored_days[ignored_object].date_attendance));
			ignored_dates.push(date_to_insert);
		}
		
		// Fetch the change day order details from the Sever and load them into change_day_order
		$.getJSON(change_day_order_url, function(data) {
			change_day_order = data;
			
			// Extract the holiday dates and compensation dates separately
			for(var change_object in change_day_order) {
				var holiday_date = $.datepicker.formatDate('dd-mm-yy', new Date(change_day_order[change_object].holiday_date));
				change_holiday.push(holiday_date);

				var compensation_date = $.datepicker.formatDate('dd-mm-yy', new Date(change_day_order[change_object].compensation_date));
				change_compensation_day.push(compensation_date);
				
				// Define an object that has all the required properties in { compensation: holiday }
				change_day_object[compensation_date] = holiday_date;
				change_compensation_order[compensation_date] = change_day_order[change_object].day_order;
			}
		});
		
		$('#date_selector').datepicker({
			dateFormat: 'dd-mm-yy',
			maxDate: new Date(),	// Make today the last possible date to select
   			beforeShowDay: function(date) {
   				var day = $.datepicker.formatDate('DD', date);
   				var date_format = $.datepicker.formatDate('dd-mm-yy', date);
   				var reason = null;
   				
   				// First check if the date was ignored?
   				// console.log("Checking if " + date_format + " is available under ignored_dates with => " + $.inArray(date_format, ignored_dates));
   				if($.inArray(date_format, ignored_dates) > -1) return [false, "", reason];
   				
   				// Check if the date is a holiday, if so do not display
   				// console.log("Checking if " + date_format + " is available under change_holiday with => "+ $.inArray(date_format, change_holiday));
   				if($.inArray(date_format, change_holiday) > -1) return [false, "", reason];
   				
   				// Now check if the date is a compensation hence should be available
   				// console.log("Checking if " + date_format + " is available under change_compensation_day with => " + $.inArray(date_format, change_compensation_day));
   				if($.inArray(date_format, change_compensation_day) > -1) {
   					// Now we need to verify if the compensation day is on the list for this course profile
   					console.log(change_compensation_order[date_format]);
   					reason = 'Compensation for ' + change_day_object[date_format];
   					day = change_compensation_order[date_format];
   				}
   				
   				// Check if the day is valid for the given Course Profile 
   				if((day in days_of_week)) return [true, "", reason];
   				else return [false, "", reason];
   			}, 
   			onSelect: function(date, inst) {
   				var _parsedDate = $.datepicker.parseDate('dd-mm-yy', date);
   				var _day = $.datepicker.formatDate('DD', new Date(_parsedDate));
   				// Logic towards hour filtering
   				//	1. Clear the list
   				$("#timeslots > option").remove();

   				// 2. First check if its an Compensation Day, If so populate based on the change_compensation_order[date] value and return
   				if($.inArray(date, change_compensation_day) > -1) {
   					// Set the _day to current compensated day
   					_day = change_compensation_order[date];
   				}
   				
   				//	3. Add the slots only those are available
   				if($.isArray(days_of_week[_day])) {
   					// Add all the values in the array to the list
   					var values = days_of_week[_day];
   					$.each(values, function(index, value) {
   						$("#timeslots").append('<option value="' + value + '">' + hours_of_day[value] + '</option>');
	   					$.uniform.update();
   					});
   				} else {
   					// Just add that element value to the List
   					$("#timeslots").append('<option value="' + days_of_week[_day] + '">' + hours_of_day[days_of_week[_day]] + '</option>');
   					$.uniform.update();
   				}
   			}
		});

	});
</script>
<?php
	end_content_for();


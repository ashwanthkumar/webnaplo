<?php

/**
 *	Created the class to put all the Attendance related methods inside here.
 *
 *	@author Ashwanth Kumar <ashwanth@ashwanthkumar.in>
 **/
class Attendance {
	
	/**
	 *	Returns the array of valid dates for the given course profile. Generally used while displaying list of possible days in the calendar.
	 *
	 *	@param	$cp_id	Course Profile ID for whcih valid Dates are to be given
	 *
	 *	@return Array of valid dates(based on the CP's Timetable)
	 **/
	public static function getValidDaysForCourseProfile($cp_id, $db) {
		// Initialize a CourseProfile object to use its properties
		$course_profile = CourseProfile::load($cp_id, $db);
		
		// Get the list of all timetable values for the given Course Profile
		$tt = $db->select("timetable", "cp_id = :cpid", array(":cpid" => $cp_id));
		
		// Contains the array of Valid days 
		// I am limiting myself to day (Monday, Tuesday, etc.), the period wise resolution is not dealt here yet. 
		// @TODO Period wise resolution of data is possible. 
		$echo_days = array();
		
		foreach($tt as $course_period) {
			$index = Attendance::getDayNameFromNumber($course_period['days_of_week']);
			// Store the Days_of_Week as the index of the array
			// and check if any of its value contain the hour_of_day
			if(isset($echo_days[$index])) {
				// If the value is already made as an Array? 
				if(is_array($echo_days[$index])) {
					// Just push the value to the array
					array_push($echo_days[$index], $course_period['hour_of_day']);
				} else {
					// Value exist but not an array yet, so we need to create one. Since the index has just a value, lets do it manually
					$new_array = array($echo_days[$index], $course_period['hour_of_day']);
					$echo_days[$index] = $new_array;
				}
			} else {
				// Such an index does not exist, so simply create one 
					$echo_days[$index] = $course_period['hour_of_day'];
			}
		}
		return $echo_days;
		//return $tt;
	}
	
	/**
	 *	Get the list of Ignored Days for the course profile
	 *
	 *	@param	$cpid	Course Profile ID
	 *	@return Array of dates and hour on which were ignored for $cpid
	 **/
	public static function getIgnoredDays($cpid, $db) {
		$ignore_days = $db->select("attendance_ignore", "cp_id = :cpid", array(":cpid" => $cpid), "date_attendance, hour");
		
		$ignore_dates = array();
		
		foreach($ignore_days as $igdate) {
			$temp_time = strtotime($igdate['date_attendance']);
			$index = date('m-d-Y', $temp_time);
			// Store the Days_of_Week as the index of the array
			// and check if any of its value contain the hour_of_day
			if(isset($ignore_dates[$index])) {
				// If the value is already made as an Array? 
				if(is_array($ignore_dates[$index])) {
					// Just push the value to the array
					array_push($ignore_dates[$index], $igdate['hour']);
				} else {
					// Value exist but not an array yet, so we need to create one. Since the index has just a value, lets do it manually
					$new_array = array($ignore_dates[$index], $igdate['hour']);
					$ignore_dates[$index] = $new_array;
				}
			} else {
				// Such an index does not exist, so simply create one 
					$ignore_dates[$index] = $igdate['hour'];
			}
		}
		
		return $ignore_days;
	}
	
	/**
	 *	General Function that returns the Changed day order values to bind statically in the program. 
	 *	@TODO Find a better use of this function.
	 *
	 *	@return Array of values from ChangeDayOrder table
	 **/
	public static function getChangeOrder($db) {
		$day_orders = $db->select("changedayorder", "1 = 1", null, "holiday_date, compensation_date, day_order");
		$_day_orders = array();
		
		foreach($day_orders as $do) {
			$do['day_order'] = Attendance::getDayNameFromNumber($do['day_order']);
			$_day_orders[] = $do;
		}
		
		return $_day_orders;
	}
	
	/**
	 *	Utility function that converts day_of_week value in Timetable to human readable name
	 *
	 *	@param	$day_value	Value of day_of_week 
	 *	@return	Human Readable name of the day
	 **/
	public static function getDayNameFromNumber($day_value) {
		switch($day_value) {
			case 1: return "Monday";
			case 2: return "Tuesday";
			case 3: return "Wednesday";
			case 4: return "Thursday";
			case 5: return "Friday";
			case 6: return "Saturday";
			case 7: return "Sunday";
		}
	}
	
	/**
	 *	Returns a valid timetable Id to be inserted based on the $course_profile, $hour_of_day, $day_of_week value. 
	 *	Used while inserting the attendance. We could use Timetable::search(), but this seems more readable. 
	 *
	 *	@param	$cp_id			Course Profile ID
	 *	@param	$date			Date to verify if ChangeDayOrder has been applied
	 *	@param	$hour_of_day	Hour of the day for which Timetable value is to be used
	 *	@param	$day_of_week	Day of the Week 
	 *
	 *	@return Valid Timetable ID if it exist else -1
	 **/
	public static function getTimetableId($cp_id, $date, $hour_of_day, $day_of_week, $db) {
		// First check id the date is marked as compensation date
		$date = date('Y-m-d', $date);	// Change the timestamp to MySQL date
		$change_day_order = $db->select("changedayorder", "compensation_date = :cdate", array(":cdate" => $date));
		if(count($change_day_order) > 0) {
			// Seems like the date is indeed marked for compensation
			$day_of_week = $change_day_order[0]['day_order'];
		}
		$tt = $db->select("timetable", "cp_id = :cpid and days_of_week = :dow and hour_of_day = :hod limit 1", array(":cpid" => $cp_id, ":dow" => $day_of_week, ":hod" => $hour_of_day));
		
		// In case of an error return -1
		if(is_object($tt) && get_class($tt) == "PDOException") return -1;
		
		// Make sure there was atleast one
		if(count($tt) < 1) return -1;
		else {
			$timetbl = $tt[0];
			return $timetbl['idtimetable'];
		}
	}
	
	/**
	 *	Clears the attendance table of any previously added attendance based on Timetable ID and
	 *	date (timestamp format) parameter. 
	 *
	 *	@param	$timetable_id			Timetable ID
	 *	@param	$date_of_attendance		Date of Attendance to Clear
	 **/
	public static function clearExistingAttendance($timetable_id, $date_of_attendance, $db) {
		return $db->delete("attendance", "date_attendance = :date and timetable_id = :ttid", array(":ttid" => $timetable_id, ":date" => $date_of_attendance));
	}
	
	/**
	 *	Insert Attendance value into the table
	 *
	 *	@param	$date_attendance	Date of Attendance
	 *	@param	$is_present			Is the Student Present?
	 *	@param	$student_id			Student Register number
	 *	@param	$timetable_id		Timetable ID
	 **/
	public static function insert($date_attendance, $is_present, $student_id, $timetable_id, $db) {
		return $db->insert("attendance", array(
										"date_attendance" => $date_attendance,
										"is_present" => $is_present, 
										"student_id" => $student_id,
										"timetable_id" => $timetable_id));
	}
}


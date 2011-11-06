<?php

class Timetable{

	private $idtimetable;
		public function getIdtimetable() 
		{ 
		return $this->idtimetable;
		}
		public function setIdtimetable($idtimetable)
		{
			$this->idtimetable = $idtimetable;
		}
	
	private $days_of_week;
		public function getDays_of_week() 
		{ 
		return $this->days_of_week;
		}
		public function setDays_of_week($days_of_week)
		{
			$this->days_of_week = $days_of_week;
		}
		
	private $hour_of_day;
		public function getHour_of_day() 
		{ 
		return $this->hour_of_day;
		}
		public function setHour_of_day($hour_of_day)
		{
			$this->hour_of_day = $hour_of_day;
		}
	
	private $Course_profile_idcourse_profile;
		public function getCourse_Profile_Idcourse_Profile() 
		{ 
		return $this->Course_profile_idcourse_profile;
		}
		public function setCourse_Profile_Idcourse_Profile($Course_profile_idcourse_profile)
		{
			$this->Course_profile_idcourse_profile = $Course_profile_idcourse_profile;
		}
	
	
	
	}

<?php

class Attendance{

	private $idattendance;
		public function getIdattendance() 
		{ 
		return $this->idattendance;
		}
		public function setIdattendance($idattendance)
		{
			$this->idattendance = $idattendance;
		}
	
	private $created_At;
		public function getCreated_At() 
		{ 
		return $this->created_At;
		}
		public function setCreated_At($created_At)
		{
			$this->created_At = $created_At;
		}
		
	private $date;
		public function getDate() 
		{ 
		return $this->date;
		}
		public function setDate($date)
		{
			$this->date = $date;
		}
		
	private $is_Present;
		public function getIs_Present() 
		{ 
		return $this->is_Present;
		}
		public function setIs_Present($is_Present)
		{
			$this->is_Present = $is_Present;
		}	
	
	private $updated_At;
		public function getUpdated_At() 
		{ 
		return $this->updated_At;
		}
		public function setUpdated_At($updated_At)
		{
			$this->updated_At= $updated_At;
		}
		
	private $student_idstudent;
		public function getStudent_idstudent() 
		{ 
		return $this->student_idstudent;
		}
		public function setStudent_idstudent($student_idstudent)
		{
			$this->student_idstudent = $student_idstudent;
		}
		
	private $Timetable_idtimetable;
		public function getTimetable_Idtimetable() 
		{ 
		return $this->Timetable_idtimetable;
		}
		public function setTimetable_Idtimetable($Timetable_idtimetable)
		{
			$this->Timetable_idtimetable = $Timetable_idtimetable;
		}
		
	
	}

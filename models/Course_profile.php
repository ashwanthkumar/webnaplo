<?php

class Course_profile{

	private $idcourse_profile;
		public function getIdcourse_profile() 
		{ 
		return $this->idcourse_profile;
		}
		public function setIdcourse_profile($idcourse_profile)
		{
			$this->idcourse_profile = $idcourse_profile;
		}
	
	private $course_Code;
		public function getCourse_Code() 
		{ 
		return $this->course_Code;
		}
		public function setCourse_Code($course_Code)
		{
			$this->course_Code = $course_Code;
		}
	
	private $name;
		public function getName() 
		{ 
		return $this->name;
		}
		public function setName($name)
		{
			$this->name = $name;
		}
	
	private $course_Name;
		public function getCourse_Name() 
		{ 
		return $this->course_Name;
		}
		public function setCourse_Name($course_Name)
		{
			$this->course_Name = $course_Name;
		}
		
	private $credits;
		public function getCredits() 
		{ 
		return $this->credits;
		}
		public function setCredits($credits)
		{
			$this->credits = $credits;
		}	
	
	private $class_idclass;
		public function getClass_idclass() 
		{ 
		return $this->class_idclass;
		}
		public function setClass_idclass($Class_idclass)
		{
			$this->idclass = $Class_idclass;
		}
	
	private $course_idcourse;
		public function getCourse_idcourse() 
		{ 
		return $this->course_idcourse;
		}
		public function setCourse_idcourse($course_idcourse)
		{
			$this->course_idcourse = $course_idcourse;
		}
		
	private $staff_idstaff;
		public function getStaff_idstaff() 
		{ 
		return $this->staff_idstaff;
		}
		public function setStaff_idstaff($staff_idstaff)
		{
			$this->staff_idstaff = $staff_idstaff;
		}
	}

<?php

// Main WebNaplo Test Class file
require_once("WebNaploTest.php");

// Including the Model files
require_once("../models/News.php");

/**
 *	Test cases for unit testing the News Model
 *
 *	@author Team Webnaplo
 *	@date 04/12/2011
 **/
class NewsTest extends WebNaploTest {

	public $db;
	
	public function __construct() {
		$this->db = $this->initDB();
	}
	
	/**
	 *	Negative test for deleting a non-existent student
	 *
	 *	@test
	 **/
	public function Delete() {
		$this->assertEquals(0, News::Delete(123094527034098,$this->db));
	}
	
	/**
	 *	Test the students against insterting a new value using the Model::save()
	 *
	 *	@test
	 **/
	public function save() {
		$news = new News;
		
		$news->news = "A sample news element goes here. This news is a strict test test only";
		$news->date = $this->timestamp("today");
		
		$this->assertEquals(1, $news->save($this->db));
		
		// Now to remove the added news
		$this->assertEquals(1, News::Delete($news->idNews, $this->db));
	}
	
	/**
	 *	Testing if the Student Block is working
	 *
	 *	@test
	 **/
	public function update() {
		$news = new News;
		
		
		$news->news = "A sample news element goes here. This news is a strict test test only";
		$news->date = $this->timestamp("today");
		
		$this->assertEquals(1, $news->save($this->db));
		
		$news_value = array("idnews" => $news->idNews, "news" => "A sample news element goes here. This news is a strict test test only. This is different and update shoud happen.");
		
		$this->assertEquals(1, News::LoadAndUpdate($news_value, $this->db));

		// Now to remove the added news
		$this->assertEquals(1, News::Delete($news->idNews, $this->db));
	}
}

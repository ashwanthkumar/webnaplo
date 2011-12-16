<?php

/**
 *	Model representing the default news items in the system
 *
 *	@author Team Webnaplo
 *	@date	04/12/2011
 **/
class News {

	public $idNews;
	public $news;
	public $date;
	public $title;
	public $type;

	/**
	 *	Saves the object in the datastore with the current instance values
	 *
	 *	@param	$db		PDOObject
	 *
	 *	@return	1 on success or PDOException on failure
	 **/
	public function save($db) {
		$r = $db->insert("news", array(
			"news" => $this->news,
			"title" => $this->title,
			"type" => $this->type,
			"date" => $this->date
		));
		
		if(is_object($r) && get_class($r) == "PDOException") return $r;
		
		// Get the current ID of the model
		$this->idNews = $db->lastInsertId();
		
		return 1;
	}
	
	/**
	 *	Updates the current instance of the object with the values from the object instance
	 *
	 *	@param	$db	PDOObject
	 **/
	public function update($db) {
		return $db->update("news", array(
			"news" => $this->news,
			"title" => $this->title,
			"type" => $this->type,
			"date" => $this->date
			), "idNews = :nid", array(":nid" => $this->idNews));
	}
	
	/**
	 *	Load the News module into the system
	 *
	 *	@param	$nid	News ID
	 *	@param	$db		PDOObject
	 *
	 *	@return	News Object based on the $nid, false if not found
	 **/
	public static function load($nid, $db) {
		$n = $db->select("news", "idNews = :nid", array(":nid" => $nid));
		
		if(count($n) > 0) {
			extract($n[0]);
			
			$_news = new News;
			$_news->idNews = $idNews;
			$_news->title = $title;
			$_news->type = $type;
			$_news->date = $date;
			$_news->news = $news;
			
			return $_news;
		} else {
			return false;
		}
	}
	
	/**
	 *	Get the type of the News item
	 *
	 *	@param	$type	News targeted for which student?
	 **/
	public static function getType($type) {
		switch($type) {
			case 1:	return "Common";
			case 2:	return "Dataentry";
			case 3:	return "Staff";
			case 4:	return "Student";
		}
	}
	
	/**
	 *	Static method to delete the news element entity from the system
	 *
	 *	@param	$nid	News element ID
	 *
	 *	@return	1 on success or PDOException on failure
	 **/
	public static function Delete($nid, $db) {
		return $db->delete("news", "idNews = :nid", array(":nid" => $nid));
	}

	/**
	 *	Loads the current value from the datastore and updates its value in the datastore
	 *
	 *	@param	$new	Array of items containing the values
	 *
	 *	@return	1 on success or PDOException on failure
	 **/
	public static function LoadAndUpdate($new, $db, &$news_object = null) {
		extract($new);

		$n = new News;
		$n->idNews = $idnews;
		$n->news = $news;
		// Get the date else set it to now
		if(isset($date)) $n->date = $date;
		else $n->date = date("Y-m-d H:i:s", time());
		
		$r = $n->update($db);
		
		$news_object = $n;
		
		return $n;
	}
	
	/**
	 *	Search the Model entities in the datastore
	 *
	 *	@param	$db			PDOObject
	 *	@param	$condition	Search Condition 
	 *	@param	$bind		Array of bound values used in $condition
	 *
	 *	@return	Array of Model entities matching the $condition
	 **/
	public static function search($db, $condition = '1=1', $bind = array()) {
		return $db->select("news", $condition, $bind);
	}
}

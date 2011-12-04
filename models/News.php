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
			"date" => $this->date
			), "idNews = :nid", array(":nid" => $this->idNews));
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
	public static function LoadAndUpdate($new, $db) {
		extract($new);

		$n = new News;
		$n->idNews = $idnews;
		$n->news = $news;
		// Get the date else set it to now
		if(isset($date)) $n->date = $date;
		else $n->date = date("Y-m-d H:i:s", time());
		
		return $n->update($db);
	}
}

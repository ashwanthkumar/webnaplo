<?php

class News {

	public $idNews;
	public $news;
	public $date;

	public function save($db) {
		return $db->insert("news", array(
			"news" => $this->news,
			"date" => $this->date
		));
	}
	
	public function update($db) {
		return $db->update("news", array(
			"news" => $this->news,
			"date" => $this->date
			), "idNews = :nid", array(":nid" => $this->idNews));
	}
	
	public static function Delete($nid, $db) {
		return $db->delete("news", "idNews = :nid", array(":nid" => $nid));
	}

	public static function LoadAndUpdate($new, $db) {
		extract($new);

		$news = new News;
		$news->idNews = $idnews;
		$news->news = $news;
		
		return $news->update($db);
	}
	
}

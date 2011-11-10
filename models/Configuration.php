<?php

/**
 *	Configuration class
 **/
class Configuration {
	public static $CONFIG_DATAENTRY_USER = "CONFIG_DATAENTRY_USER";
	public static $CONFIG_DATAENTRY_PASSWORD = "CONFIG_DATAENTRY_PASSWORD";
	
	public static $CONFIG_ADMIN_USER = "CONFIG_ADMIN_USER";
	public static $CONFIG_ADMIN_PASSWORD = "CONFIG_ADMIN_PASSWORD";

	public static $CONFIG_SEM_START_DATE = "CONFIG_SEM_START_DATE";
	
	public static function get($key, $db, $returnValue = false) {
		if(!$returnValue) 
			return $db->select("configuration", "`key` = :key limit 1", array(":key" => $key));
		else {
			$config = $db->select("configuration", "`key` = :key limit 1", array(":key" => $key));
			return $config[0]['value'];
		}
	}
	
	public static function put($key, $value, $db) {
		$config = $db->select("configuration", "key = :key", array(":key" => $key));
		
		// Config found so just update it
		if(count($config) > 0)	return $db->update("configuration", array("`key`" => $key, "value" => $value), "`key` = :key", array(":key" => $key));
		// Config not found so just add it
		else	return $db->insert("configuration", array("`key`" => $key, "value" => $value));
	}
}


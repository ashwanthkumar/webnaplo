<?php
class System {

	public static $version = "1.2"; 
	public static $code_name = "Lunar Eclipse";
	public static $build = 1324666800; 
		
	public static function getWokingDaysTillNow($db) {
		$semStartDate = Configuration::get(Configuration::$CONFIG_SEM_START_DATE, $db);
		$semStart = strtotime($semStartDate[0]['value']);
		
		$yesterday = strtotime("yesterday");
		$currentTimeProcessing = $semStart;

		$dayInterval = DateInterval::createFromDateString("1 day");
		
		$workingDays = array();
		while($currentTimeProcessing < $yesterday) {
			$date = new DateTime(date('Y-m-d H:i:s',$currentTimeProcessing));
			$date->add($dayInterval);
			
			$currentTimeProcessing = $date->getTimestamp();
			$day = date('D',$currentTimeProcessing);
			
			if($day == "Sun" or $day == "Sat") {
				continue;
				// Continue if its Weekend. 
				// @TODO Need to implement Day Change order here
			}
			
			$workingDays[] = date('Y-m-d H:i:s',$currentTimeProcessing);
		}
		
		// Return the number of working days
		return $workingDays;
	}
}
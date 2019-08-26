<?php 
	namespace app\helpers;

use Yii;
use app\models\User;

class ApplicationHelper{

	/**
	* getFirstAndLastDayOfMonth returns first and last day of month.
	* returns type: array
	* $current_day is timestamp
	*/

	public static $pl_en = array(
					"Ę" => "E",
					"Ó" => "O",
					"Ą" => "A",
					"Ś" => "S",
					"Ł" => "L",
					"Ż" => "Z",
					"Ź" => "Z",
					"Ć" => "C",
					"Ń" => "N",
					"ę" => "e",
					"ó" => "o",
					"ą" => "a",
					"ś" => "s",
					"ł" => "l",
					"ż" => "z",
					"ź" => "z",
					"ć" => "c",
					"ń" => "n",
					" " => "_",
				);

	public static function getFirstAndLastDayOfMonth($current_day){
		$result = [];
		$result["first_day"] = strtotime( date('Y-m-01', $current_day) );
		$result["last_day"] = strtotime( date('Y-m-t 23:59:59', $current_day) );
		return $result;
	}

	public static function getFirstAndLastDayOfWeek($current_day){
		$day = date('w');
		// $result["first_day"] = date('Y-m-d', strtotime('-'.$day.' days'));
		$result["first_day"] = date('Y-m-d 23:59:59', strtotime('-'.$day.' days'));
		$result["last_day"] = date('Y-m-d 23:59:59', strtotime('+'.(7-$day).' days'));
		return $result;
	}

	public function replace_pl_str_to_en($str){
		return strtr($str, self::$pl_en);
	}
}
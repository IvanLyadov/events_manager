<?php 
namespace app\helpers;

use Yii;

class TimeHelper{


	public static function getDayTimeRange( $timestamp = 0 )
	{
		$beginOfDay = strtotime( "midnight", $timestamp );
		$endOfDay   = strtotime( "tomorrow", $beginOfDay ) - 1;

		return [
			'begin' => $beginOfDay,
			'end' => $endOfDay,
		];
	}

	public static function getPolishDayName($dayname, $lang = "english")
	{
		$dayNameCapitalized = ucfirst($dayname);

		$english_to_polish = [
			"Monday"	=> "Poniedziałek",
			"Tuesday"	=> "Wtorek",
			"Wednesday"	=> "Środa",
			"Thursday"	=> "Czwartek",
			"Friday"	=> "Piątek",
			"Saturday"	=> "Sobota",
			"Sunday"	=> "Niedziela"
		];

		switch ( strtolower($lang) )
		{
			case 'english':
				return $english_to_polish[$dayNameCapitalized];
				break;


			default:
				return $dayname;
				break;
		}
	}

	public static function getShortPolishDayName($dayname, $lang = "english")
	{
		$dayNameCapitalized = ucfirst($dayname);

		$english_to_polish = [
			"Monday"	=> "Pon",
			"Tuesday"	=> "Wto",
			"Wednesday"	=> "Śro",
			"Thursday"	=> "Czw",
			"Friday"	=> "Pią",
			"Saturday"	=> "Sob",
			"Sunday"	=> "Nie"
		];

		switch ( strtolower($lang) )
		{
			case 'english':
				return $english_to_polish[$dayNameCapitalized];
				break;


			default:
				return $dayname;
				break;
		}
	}

}
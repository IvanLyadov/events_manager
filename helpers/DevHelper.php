<?php

namespace app\helpers;

class DevHelper{



	public static function printr($string=null)
	{
		$output = print_r($string, true);
		$output = str_replace(" ", "&nbsp;", $output);
		$output = nl2br($output);
		echo($output."<br><br>");

		return 0;
	}

}
<?php 
	namespace app\helpers;

use Yii;
use app\models\User;

class PlacesHelper{

	public function getNavbar()
	{
		if ( Yii::$app->user->identity && Yii::$app->user->identity->admin == User::ADMIN_LEVEL ) {
			return "/places/_admin_navbar.php";
		}
		else{
			return "/places/_user_navbar.php";
		}
	}

	public function getPermition()
	{
		if ( Yii::$app->user->identity && Yii::$app->user->identity->admin == User::ADMIN_LEVEL ) {
			return true;
		}
		else{
			return false;
		}
	}

}
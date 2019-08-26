<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Clubs;

class ApplicationController extends Controller
{

	/*
		Yii2 controller class requirements
	*/
	public function __construct($id, $module, $config = [])
	{
		parent::__construct($id, $module, $config);

	}

	public function beforeAction($action)
	{
		if ( Yii::$app->user->identity == NULL) {
			Yii::$app->getSession()->setFlash('login_error', 'Zaloguj się, aby korzystać z zasobów systemu.');

			$this->redirect(['/login']);
			return false;
		}
		else{
			if ($this->getPermition()) {
				$this->layout = "administrator";
			}
			return parent::beforeAction($action);
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

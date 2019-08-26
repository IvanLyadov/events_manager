<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\User;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

class RegistrationController extends Controller
{
	public function actionRegister()
	{
		$session = Yii::$app->session;

		$userdata = json_decode( $session->getFlash('userdata'), 1);
		$userdata['scenario'] = 'register';

		$model = new User( $userdata );
		$data = array(
				'model' => $model,
			);

		return $this->render('registration', $data);
	}

	public function actionRegisterSubmit()
	{
		$user = new User(['scenario' => 'register']);
		$user->load(Yii::$app->request->post());
		$user->password = md5($user->password);
		$user->passwordConfirm = md5($user->passwordConfirm);



		if ( $user->validate() ) {
			$user->type = "coach";
			$user->save();
			$user->sendEmailAfterSave();
			Yii::$app->session->setFlash('reg_success', "Wysłaliśmy do Ciebie e-mail z linkiem aktywacyjnym. Po aktywacji konta możliwe będzie zalogowanie się do systemu!");

			return $this->redirect('login');
		}else
		{
			$this->clearUserSensitiveData($user);
			$userdata = json_encode($user->attributes);

			Yii::$app->session->setFlash('userdata', $userdata);
			Yii::$app->session->setFlash('error', "Podany email już istnieje w systemie!");


			return $this->redirect('registration');
		}
	}

	public function actionUserActivation($token)
	{
		$token_decoded = base64_decode($token);
		$conf_deserialized = unserialize($token_decoded);

		$user = User::findOne([
				'activation_token' => $conf_deserialized['token'],
				'email' => $conf_deserialized['email']
			]);

		if ( $user && $user->active == 0){
			$user->active = 1;
			$user->save(false);

			Yii::$app->session->setFlash('reg_success', "Witamy w sytemie TDS! Twoje konto zostało pomyślenie aktywowane.");
			$this->redirect('login');
		}else{
			echo "Access denied";
		}
	}

	private function clearUserSensitiveData($user)
	{
		$user->password = null;
		$user->passwordConfirm = null;
		$user->email = null;

		return $user;
	}

}

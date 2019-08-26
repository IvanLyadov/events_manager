<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\User;
use yii\helpers\Url;

class AuthController extends Controller
{
	public function actionLogin()
	{

		$data= array(
			'model' => new User(['scenario' => 'login']),
		);

		return $this->render('login', $data);
	}

	public function actionLoginSubmit()
	{
		$userPostData = Yii::$app->request->post("User");

		$user = User::findOne([
			'email' => $userPostData['email'],
			'password' => User::encryptPass($userPostData['password']),
			'active' => "1",
		]);

		if ($user) {
			Yii::$app->user->login($user);
			// $user->last_login_timestamp = time();
			// $user->save();
			return $this->redirect(['/']);
		}
		else
		{
			Yii::$app->getSession()->setFlash('login_error', 'Nieprawidłowe dane, lub użytkownik nie został aktywowany.');
			return $this->redirect(['index.php/login']);
		}
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->redirect(['index.php/login']);
	}

	public function actionResetUserPassword()
	{
		$user_model = new User();
		$data= array(
			'action' => Url::to(['index.php/reset_password']),
			'user_model' => $user_model,
		);
		return $this->render('reset_user_password', $data);
	}

	public function actionSendToUserVerification()
	{
		$user_model = new User();
		$user_model->load( Yii::$app->request->post() );
		$search_user = $user_model->findOne(['email' => $user_model->email]);

		if (!empty($search_user)) {
			$token = $user_model->generateToken();

			$search_user->activation_token = $token;
			$search_user->active_token = 1;
			if (!$search_user->validate()) {
				return false;
			}
			$search_user->save();

			$conf = [
				'email' => $search_user->email,
				'token' => $search_user->activation_token,
				'timestamp' => time(),
			];
			$serialized_conf = serialize($conf);
			$token_encoded = base64_encode($serialized_conf);
			$email_messege = '<table><tr><td>Aby zmienić hasło skorzystaj z linku poniżej:</td></tr><tr><td><a href="'.Url::to('@web/index.php/new_password?token='.$token_encoded, true).'">'.Url::to('@web/index.php/useractivation/'.$token_encoded, true).'</a></td></tr></table>';
			$user_model->sendEmail( 'no-reply@admin.com', $search_user->email, 'Resetowanie hasła użytkownika', '', $email_messege);

			Yii::$app->getSession()->setFlash('reg_success', 'Email został wysłany, proszę sprawdzić e-mail.');
			return $this->redirect(['/reset_password']);

		}else{
			Yii::$app->getSession()->setFlash('login_error', 'Podany adres e-mail nie istnieje');
			return $this->redirect(['/reset_password']);
		}

	}

	public function actionNewUserPassword($token)
	{
		$token_decoded = base64_decode($token);
		$conf_deserialized = unserialize($token_decoded);

			$user = User::findOne([
					'activation_token' => $conf_deserialized['token'],
					'email' => $conf_deserialized['email'],
					'active_token' => 1,
				]);

			if ( $user ){
				$generated_password = $user->generateRandomString();
				$user->password = md5($generated_password);
				$user->active_token = 0;
				if ($user->validate()) {
					$user->save();
				}

				$email_messege = '<table><tr><td>Nowe hasło do panelu TDS:</td></tr><tr><td>'.$generated_password.'</td></tr></table>';
				$user->sendEmail( 'no-reply@admin.com', $user->email, 'Nowe hasło użytkownika:', '', $email_messege);

				Yii::$app->getSession()->setFlash('reg_success', 'Nowe hasło zostało wysłane na email.');
				return $this->redirect(['/login']);

			}else{
				Yii::$app->getSession()->setFlash('reg_success', '404');
				return $this->redirect(['/login']);
			}
	}

}

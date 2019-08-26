<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\controllers\ApplicationController;
use yii\helpers\Url;


class UsersController extends ApplicationController
{

	public function actionIndex()
	{
		$trainer = Yii::$app->user->identity;
		$users = $trainer->clients;

		$data = [
			'users' => $users,
			'edit_url' => Url::to(['index.php/clients/edit']),
			'delete_url' => Url::to(['index.php/clients/delete']),
			'add_url' => Url::to(['index.php/clients/new']),
			'trainings_url' => Url::to(['index.php/trainings']),
			'sendemail_url' => Url::to(['index.php/clients/send_email']),
			'add_training' => Url::to(['index.php/trainings/new']),
			'delete_client' => Url::to(['index.php/clients/delete-client']),
		];
		return $this->render('index', $data);
	}

	public function actionNew()
	{
		$data = [
			'users' => [
				'user_model' => new User(['scenario' => 'register']),
				'action_url' => Url::to(['index.php/clients/new']),
				'return_url' => Url::to(['index.php/clients']),
			]
		];
		return $this->render('new', $data);
	}

	public function actionAddUser()
	{
		$trainer = Yii::$app->user->identity;

		$user = User::findOne([
			'email' => Yii::$app->request->post('User')['email'],
		]);

		if ( $user != null )
		{
			if ( !$user->isAssignedToTrainer($trainer) )
			{
				$user->assignTrainer($trainer);
				$user->notifyAboutAssignmentToTrainer($trainer);
				Yii::$app->session->setFlash('user_message', "Klient został dodany");
			}
			else
			{
				Yii::$app->session->setFlash('user_message-error', "Użytkownik jest już Twoim klientem");
			}
		}
		else
		{
			$user = new User(['scenario' => User::SCENARIO_CREATED_BY_TRAINER]);
			$user->load( Yii::$app->request->post() );

			$generated_password = User::generateRandomPassword();
			$user->password = md5($generated_password);
			$user->phone = preg_replace("/[^0-9]/", '', $user->phone);

			if ( $user->validate() )
			{
				if (strlen($user->phone) >= 7)
				{
					if ( $user->save() )
					{
						$user->assignTrainer($trainer);
						$user->notifyAboutAccountCreatedByTrainer($trainer,$generated_password);

						Yii::$app->session->setFlash('user_message', "Klient został dodany");
					}
				}
				else
				{
					Yii::$app->session->setFlash('user_message-error', "Błąd podczas zapisania, niewłaściwy numer telefonu");
					return $this->redirect(Url::to(['index.php/clients']));
				}
			}else{
				$errors = $user->errors;
			}
		}

		return $this->redirect(Url::to(['index.php/clients']));
	}

	/*
		DEPRECATED (by pawlz), replaced by User::generateRandomPassword()
	*/
	public function generateRandomString()
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 10; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}


	public function actionSendUserEmail($user_id)
	{
		$data = [
			'action_url' => Url::to(['index.php/clients/send_email?user_id='.$user_id]),
			'return_url' => Url::to(['index.php/clients']),
		];
		return $this->render('send-email', $data);
	}

	public function actionSubmitUserEmail($user_id)
	{
		$request = Yii::$app->request->post();

		$trainer = Yii::$app->user->identity;
		$user = $trainer->getClients()->where(['id' => $user_id])->one();

		if ( $user )
		{
			$user_model = new User();
			$user_model->sendEmail($trainer->email , $user->email, $request['title'], '', $request['message']);
			Yii::$app->session->setFlash('user_message', "Email został wysłany");
		}
		else
		{
			Yii::$app->session->setFlash('user_message-error', "Klient nie istnieje");
		}

		return $this->redirect(Url::to(['index.php/clients']));
	}

	public function actionDeleteClient($id)
	{
		$trainer = Yii::$app->user->identity;
		$user = User::findOne($id);

		if ( $user->isAssignedToTrainer($trainer) )
		{
			$user->unAssignTrainer($trainer);
			Yii::$app->session->setFlash('user_message', "Klient został usunięty!");
		}

		return $this->redirect(Url::to(['index.php/clients']));
	}
}

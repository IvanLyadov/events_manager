<?php

namespace app\controllers;

use Yii;
//use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\User;
use app\controllers\ApplicationController;
use yii\helpers\Url;
use yii\web\UploadedFile;
use app\models\UsersImages;
use app\models\Places;
use app\models\Trainings;
use yii\data\Pagination;

class UserController extends ApplicationController
{
	public function __construct($id, $module, $config = [])
	{
		parent::__construct($id, $module, $config);
	}

	public function actionIndex()
	{
		$user_status = Yii::$app->user->identity->type;
		$id_traner = Yii::$app->user->identity->id;
		$full_name = Yii::$app->user->identity->first_name. " " . Yii::$app->user->identity->last_name;
		$users_images_records = UsersImages::find()
		->where(['id_user' => $id_traner])
		->orderBy('id DESC');
		$pagination = new Pagination(['totalCount' => $users_images_records->count(),'defaultPageSize' => 35]);
		$users_images_pagination = $users_images_records->offset($pagination->offset)->limit($pagination->limit)->all();


		$data = [
			'full_name' => $full_name,
			'user_status' => $user_status,
			'user' => Yii::$app->user->identity,
			'profile_edit_url' => Url::to(['index.php/profile/edit']),
			'password_edit' => Url::to(['index.php/user/password-edit']),
			'gallery_url' => Url::to(['index.php/gallery']),
			'pagination' => $pagination,
			'trainer_images' => $users_images_pagination,
		];
		return $this->render('index', $data);
	}

	public function actionPasswordEdit()
	{
		$user = new User();
		$user->scenario = User::SCENARIO_PASSWORD_EDIT;

		$full_name = Yii::$app->user->identity->first_name. " " . Yii::$app->user->identity->last_name;
		$data = [
			'full_name' => $full_name,
			'user' => $user,
			'form_action' => Url::to(['index.php/user/edit-password-save']),
			'return_url' => Url::to(['index.php/profile']),
		];

		return $this->render('password_edit', $data);
	}

	public function actionEditPasswordSave()
	{
		$user = User::findOne(Yii::$app->user->identity->id);

		$post_request = Yii::$app->request->post();
		print_r($post_request);
		$user->load( Yii::$app->request->post() );
		if ($user->password != md5($post_request['User']['password'])) {
			Yii::$app->session->setFlash('user_message-error', "Haslo użytkownika nie jest poprawne");
			return $this->redirect(Url::to(['/user/password-edit']));
		}

		if ($post_request['User']['passwordChange'] == $post_request['User']['passwordRepeat']) {
			$user->password = md5($post_request['User']['passwordChange']);
			$user->validate();
			$user->save();
			Yii::$app->session->setFlash('user_message', "Haslo użytkownika zostało zmienione");

			$htmlbody = "Hasło użytkownika " . $user->email . " w serwisie NotesTrenera zostało właśnie zmienione. <br>Zignoruj tę wiadomość, jeżeli ta zmiana została dokonana przez Ciebie. <br>Jeżeli nie ty jej dokonałeś, to jak najszybciej zmień swoje hasło w serwisie (opcja resetuj hasło na ekranie logowania) i daj nam znać na e-mail bok@notestrenera.pl
";
			$user->sendEmail('tds@no-reply', $user->email , "Zmiana hasła w systemie TDS", "", $htmlbody);
		}

		return $this->redirect(Url::to(['index.php/profile']));
	}

	public function actionEdit()
	{
		$full_name = Yii::$app->user->identity->first_name. " " . Yii::$app->user->identity->last_name;
		$data = [
			'full_name' => $full_name,
			'user' => Yii::$app->user->identity,
			'form_action' => Url::to(['index.php/profile/edit']),
			'return_url' => Url::to(['index.php/profile']),
		];

		return $this->render('edit', $data);
	}

	public function actionSave()
	{
		$user = User::findOne(Yii::$app->user->identity->id);
		$user->load( Yii::$app->request->post() );
		$post_request = Yii::$app->request->post();

		// if (!empty($post_request['User']['password'])) {
		// 	$user->password = md5($post_request['User']['password']);
		// }
		if ($user->validate()) {
				$user->save();

				$user->userFiles = UploadedFile::getInstance($user, 'userFiles');
			if ($user->upload()) {
				echo 'file is uploaded successfully';
			}else {
				$errors = $user->errors;
			}
		}

		return $this->redirect(Url::to(['index.php/profile']));
	}

	public function actionClubs()
	{
		$clubs_model = Clubs::find()->asArray()->all();
		$data = [
			'clubs_model' => $clubs_model,
		];
		return $this->render('clubs', $data);
	}

	public function actionClubAssign($id){

		$id_traner = Yii::$app->user->identity->id;

		$clubs_trainers = new ClubsTrainers();
		$clubs_trainers->confirmed = 0;
		$clubs_trainers->id_user = $id_traner;
		$clubs_trainers->id_club = $id;
		if ($clubs_trainers->validate()) {
			$clubs_trainers->save();
		}

		Yii::$app->session->setFlash('user_message', "Zgłoszenie zostało wysłane do zatwierdzenia");
		return $this->redirect(Url::to(['index.php/profile']));


	}



}

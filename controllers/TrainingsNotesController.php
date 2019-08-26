<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\ApplicationController;
use yii\helpers\Url;
use app\models\Activities;
use app\models\User;
use app\models\TrainingsNotes;
use app\models\Trainings;
use yii\base\ErrorException;


class TrainingsNotesController extends ApplicationController
{

	private function trainerHasUser($id_user)
	{
		$trainer = Yii::$app->user->identity;
		$trainerHasUser = $trainer->getClients()->where(['id' => $id_user])->one();

		if ( empty($trainerHasUser) ){
			throw new ErrorException("Brak uprawień.");
		}
	}

	public function actionShow($id_user, $id)
	{
		$id_trainer = Yii::$app->user->identity->id;
		try{
			$this->trainerHasUser($id_user);
		}
		catch( \yii\base\ErrorException $e)
		{
			Yii::$app->session->setFlash('user_message-error', $e->getMessage() );
			return $this->redirect( Url::to(['/']) );
			die();
		}

		$trainings_notes = TrainingsNotes::findAll(['id_training' => $id]);
		$trainings = Trainings::findOne(['id' => $id]);
		if (empty($trainings)) {
			return $this->redirect( Url::to(['/']) );
		}
		$data = [
			'trainings_notes' => $trainings_notes,
			'trainings' => $trainings,
			'return_url' => Url::to(['index.php/trainings?id_user='.$id_user]),
			'add_note_url' => Url::to(['index.php/trainings_notes/new', 'id_user' => $id_user, 'id' => $id]),
			'edit_note_url' => Url::to(['index.php/trainings_notes/edit', 'id_user' => $id_user, 'id_trening' => $id]),
			'delete_note_url' => Url::to(['index.php/trainings_notes/delete', 'id_user' => $id_user, 'id_trening' => $id]),
		];
		return $this->render('show-note', $data);
	}


	public function getUserGroup($config = [])
	{
		$instance = User::find()->where($config)->one();

		if ( $instance == NULL )
			throw new ErrorException("Brak uprawień!");
		else
		{
			return $instance;
		}
	}

	public function actionNew($id_user, $id)
	{

		try{
			$this->trainerHasUser($id_user);
		}
		catch( \yii\base\ErrorException $e)
		{
			Yii::$app->session->setFlash('user_message-error', $e->getMessage() );
			return $this->redirect( Url::to(['/']) );
			die();
		}

		$trainer_id = Yii::$app->user->identity->id;
		$getTraining = Trainings::findOne(['id' => $id, 'id_coach' => $trainer_id]);
		if (empty($getTraining)) {
			return $this->redirect( Url::to(['/']) );
		}

		$data = [
				'trainings_notes_model' => new TrainingsNotes(),
				'action_url' => Url::to(['index.php/trainings_notes/new', 'id_user'=> $id_user,'id'=>$id]),
				'return_url' => Url::to(['index.php/trainings_notes/show_note','id_user' => $id_user, 'id' => $id]),
			];
		return $this->render('new-note', $data);
	}

	public function actionSave($id_user, $id)
	{
		$trainer_id = Yii::$app->user->identity->id;
		$trainings_notes = new TrainingsNotes();
		$trainings_notes->load( Yii::$app->request->post() );

		if ($trainings_notes->validate()) {
			$trainings_notes->id_training = $id;
			$trainings_notes->save();
		}else{
			$errors = $trainings_notes->errors;
		}
		Yii::$app->session->setFlash('user_message', "Notatka została dodana");
		return $this->redirect(Url::to(['index.php/trainings?id_user='.$id_user]));
	}

	public function actionEdit($id_user, $id , $id_trening)
	{
		try{
			$this->trainerHasUser($id_user);
		}
		catch( \yii\base\ErrorException $e)
		{
			Yii::$app->session->setFlash('user_message-error', $e->getMessage() );
			return $this->redirect( Url::to(['/']) );
			die();
		}
		$trainings_notes_model = TrainingsNotes::findOne(['id' => $id]);
		if (empty($trainings_notes_model)) {
			return $this->redirect( Url::to(['/']) );
		}

		$data = [
				'trainings_notes_model' => $trainings_notes_model,
				'action_url' => Url::to(['index.php/trainings_notes/edit', 'id'=> $id, 'id_user' => $id_user, 'id_trening'=> $id_trening]),
				'return_url' => Url::to(['index.php/trainings_notes/show_note', 'id_user' => $id_user, 'id'=> $id_trening]),
		];
		return $this->render('edit', $data);
	}

	public function actionUpdate($id_trening, $id_user, $id)
	{
		$trainings_notes_model = TrainingsNotes::findOne(['id' => $id]);
		$trainings_notes_model->load( Yii::$app->request->post() );

		if ($trainings_notes_model->validate()) {
			$trainings_notes_model->save();

			Yii::$app->session->setFlash('user_message', "Notatka została zapisana");
			return $this->redirect(Url::to(['index.php/trainings_notes/show_note', 'id_user' => $id_user, 'id'=> $id_trening]));
		}else{
			$errors = $user->errors;
		}
	}


	public function actionDelete($id, $id_user, $id_trening)
	{
		try{
			$this->trainerHasUser($id_user);
		}
		catch( \yii\base\ErrorException $e)
		{
			Yii::$app->session->setFlash('user_message-error', $e->getMessage() );
			return $this->redirect( Url::to(['/']) );
			die();
		}

		$trainings_notes_model = TrainingsNotes::findOne(['id' => $id]);

		if ($trainings_notes_model->delete()) {
			Yii::$app->session->setFlash('user_message', "Notatka zostałą usunięta");
			return $this->redirect(Url::to(['index.php/trainings_notes/show_note', 'id_user' => $id_user, 'id'=> $id_trening]));
		}else{
			$errors = $user->errors;
		}
	}




}

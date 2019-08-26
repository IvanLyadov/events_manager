<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\ApplicationController;
use yii\helpers\Url;
use app\models\User;
use app\models\TrainingsNotes;
use app\models\Trainings;
use app\models\UserTask;
use app\models\UsersCalendarAvailability;
use yii\base\ErrorException;
use yii\data\Pagination;


class TrainingsController extends ApplicationController
{

	private function trainerHasUser($id_user)
	{
		$trainer = Yii::$app->user->identity;
		$trainerHasUser = $trainer->getClients()->where(['id' => $id_user])->one();

		if ( empty($trainerHasUser) ){
			throw new ErrorException("Brak uprawień.");
		}
	}

	public function actionShow($id_user)
	{
		try{
			$this->trainerHasUser($id_user);
		} catch( \yii\base\ErrorException $e) {
			Yii::$app->session->setFlash('user_message-error', $e->getMessage() );
			return $this->redirect( Url::to(['/']) );
		}

		$id_trainer = Yii::$app->user->identity->id;
		$trainer = Yii::$app->user->identity;

		$trainings_model = Trainings::find()
			->where(['id_coach' => $id_trainer, 'id_user' => $id_user])
			->orderBy('id DESC');

		$pagination = new Pagination(['totalCount' => $trainings_model->count(),'defaultPageSize' => 50]);
		$trainings = $trainings_model->offset($pagination->offset)->limit($pagination->limit)->all();

		$data = [
			'pagination' => $pagination,
			'trainings' => $trainings,
			'user_name' => $this->getUserGroup(['id' => $id_user]),
			'get_back_url' => Url::to(['index.php/clients']),
			'edit_url' => Url::to(['index.php/trainings/edit', 'id_user' => $id_user]),
			'delete_url' => Url::to(['index.php/trainings/delete', 'id_user' => $id_user]),
			'add_url' => Url::to(['index.php/trainings/new?id_user='.$id_user]),
			'add_note_url' => Url::to(['index.php/trainings_notes/new?id_user='.$id_user]),
			'show_note_url' => Url::to(['index.php/trainings_notes/show_note?id_user='.$id_user]),
		];
		return $this->render('show', $data);
	}

	public function getUserGroup($config = [])
	{
		$instance = User::find()->where($config)->one();
		if ( !empty($instance) ){
			return $instance;
		}
	}

	public function actionNew($id_user)
	{
		try{
			$this->trainerHasUser($id_user);
		} catch( \yii\base\ErrorException $e) {
			Yii::$app->session->setFlash('user_message-error', $e->getMessage() );
			return $this->redirect( Url::to(['/']) );
		}

		$data = [
			'trainings' => [
				'trainings_model' => new Trainings(),
				'action_url' => Url::to(['index.php/trainings/new', 'id_user'=> $id_user]),
				'return_url' => Url::to(['index.php/trainings?id_user='.$id_user]),
			]
		];
		return $this->render('new', $data);
	}

	public function actionSave($id_user)
	{
		$id_trainer = Yii::$app->user->identity->id;

		try{
			$this->trainerHasUser($id_user);
		} catch( \yii\base\ErrorException $e) {
			Yii::$app->session->setFlash('user_message-error', $e->getMessage() );
			return $this->redirect( Url::to(['/']) );
		}

		$trainings = new Trainings();
		$trainings->load( Yii::$app->request->post() );

		$trainings->training_date =Yii::$app->formatter->asDate($trainings->training_date, "dd.MM.yyyy");
		if ($trainings->validate()) {

			if ($trainings->start_ts) {

				$trainings->start_ts = $trainings->training_date.' '.$trainings->start_ts;
				$trainings->start_ts = $this->dateToTimestamp($trainings->start_ts);
			}

			if ($trainings->end_ts) {
				$trainings->end_ts = $trainings->training_date.' '.$trainings->end_ts;
				$trainings->end_ts = $this->dateToTimestamp($trainings->end_ts);
			}

			$trainings->created_ts = time();
			$trainings->id_coach = $id_trainer;
			$trainings->id_user = $id_user;

			unset($trainings->training_date);

			if ($trainings->start_ts < $trainings->end_ts) {
				$trainings->save();
			} else {
				Yii::$app->session->setFlash('user_message-error', "Błąd podczas zapisania, data rozpoczęcia treningu jest późniejsza od daty zakończenia.");
				return $this->redirect(Url::to(['index.php/trainings?id_user='.$id_user]));
			}
		}else{
			Yii::$app->session->setFlash('user_message-error', "Błąd podczas zapisania");
			return $this->redirect(Url::to(['index.php/trainings?id_user='.$id_user]));
		}

		Yii::$app->session->setFlash('user_message', "Trening został dodany");
		return $this->redirect(Url::to(['index.php/trainings?id_user='.$id_user]));

	}

	public function actionCheckTraingTimeRange(){
		$user = Yii::$app->user->identity;
		$post_request = Yii::$app->request->post();
		$start_ts = $post_request['start_ts'] -1;
		$end_ts = $post_request['end_ts'] +1;

		$trainings = Trainings::find()
			->where('(start_ts >= '. $start_ts. ' AND end_ts >= '. $end_ts . ') AND ( start_ts < '. $end_ts . ' AND end_ts > ' . $end_ts . ')')
			->orWhere('(start_ts <= '. $start_ts. ' AND end_ts <= '. $end_ts . ') AND ( end_ts > '. $start_ts . ' AND start_ts < ' . $start_ts . ')')
			->orWhere('start_ts >= '. $start_ts. ' AND end_ts <= '. $end_ts)
			->orWhere('start_ts <= '. $start_ts. ' AND end_ts >= '. $end_ts)
			->andWhere(['id_coach' => $user->id ]);

		$result = array(
					'trainings' => !empty($trainings->all()),
				);
		return json_encode($result);
	}

	// important, format of the date string: d.m.Y H:i:s
	public function dateToTimestamp($time_str)
	{
		$time_table =  explode(" ",$time_str);
		$days_tb = explode('.', $time_table[0]);
		$hours_tb = explode(':', $time_table[1]);
		return mktime($hours_tb[0],$hours_tb[1],0,$days_tb[1], $days_tb[0], $days_tb[2] );
	}

	public function actionEdit($id, $id_user)
	{
		try{
			$this->trainerHasUser($id_user);
		} catch( \yii\base\ErrorException $e) {
			Yii::$app->session->setFlash('user_message-error', $e->getMessage() );
			return $this->redirect( Url::to(['/']) );
		}
		$trainings_model = Trainings::findOne(['id' => $id]);
		if (empty($trainings_model)) {
			return $this->redirect( Url::to(['/']) );
		}

		$data = [
			'trainings' => [
				'trainings_model' => $trainings_model,
				'action_url' => Url::to(['/trainings/edit', 'id'=> $id, 'id_user' => $id_user]),
				'return_url' => Url::to(['/trainings?id_user='.$id_user]),
			]
		];
		return $this->render('edit', $data);
	}

	public function actionUpdate($id, $id_user)
	{
		$id_trainer = Yii::$app->user->identity->id;
		$trainings_model = Trainings::findOne(['id' => $id]);
		$trainings_model->load( Yii::$app->request->post());
		$post_request = Yii::$app->request->post();
		$trainings_model->training_date =Yii::$app->formatter->asDate($trainings_model->training_date, "dd.MM.yyyy");

			if ($trainings_model->start_ts) {
				$trainings_model->start_ts = $trainings_model->training_date.' '.$trainings_model->start_ts;
				$trainings_model->start_ts = $this->dateToTimestamp($trainings_model->start_ts);
			}

			if ($trainings_model->end_ts) {
				$trainings_model->end_ts = $trainings_model->training_date.' '.$trainings_model->end_ts;
				$trainings_model->end_ts = $this->dateToTimestamp($trainings_model->end_ts);
			}
			unset($trainings_model->training_date);

			if ($trainings_model->start_ts < $trainings_model->end_ts) {
				$trainings_model->save();
			} else {
				Yii::$app->session->setFlash('user_message-error', "Błąd podczas zapisywania, data rozpoczęcia treningu jest późniejsza od daty zakończenia.");
				return $this->redirect(Url::to(['index.php/trainings?id_user='.$id_user]));
			}

		Yii::$app->session->setFlash('user_message', "Trening został zapisany");
		return $this->redirect(Url::to(['index.php/trainings?id_user='.$id_user]));

	}

	public function actionDelete($id, $id_user)
	{
		try{
			$this->trainerHasUser($id_user);
		} catch( \yii\base\ErrorException $e) {
			Yii::$app->session->setFlash('user_message-error', $e->getMessage() );
			return $this->redirect( Url::to(['/']) );
		}
		$trainings_model = Trainings::findOne(['id' => $id]);
		if ($trainings_model->delete()) {
			Yii::$app->session->setFlash('user_message', "Trening został usunięty");
			return $this->redirect(Url::to(['index.php/trainings', 'id_user' => $id_user]));
		}else{
			$errors = $user->errors;
		}
	}

	public function actionNewNote($id_user, $id)
	{

		try{
			$this->trainerHasUser($id_user);
		} catch( \yii\base\ErrorException $e) {
			Yii::$app->session->setFlash('user_message-error', $e->getMessage() );
			return $this->redirect( Url::to(['/']) );
		}

		$trainer_id = Yii::$app->user->identity->id;

		$getTraining = Trainings::findOne(['id' => $id, 'id_coach' => $trainer_id]);
		if (empty($getTraining)) {
			return $this->redirect( Url::to(['/']) );
		}

		$data = [
			'trainings_notes_model' => new TrainingsNotes(),
			'action_url' => Url::to(['index.php/trainings/new_note', 'id_user'=> $id_user,'id'=>$id]),
			'return_url' => Url::to(['index.php/trainings?id_user='.$id_user]),
		];
		return $this->render('new-note', $data);
	}

	public function actionNewNoteSave($id_user, $id)
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

	public function actionTrainingsCalendar($dayTime=null)
	{
		$user = Yii::$app->user->identity;

		if ( $dayTime == null ) {
			$dayTime = time();
		}
		$dayTimerange = \app\helpers\TimeHelper::getDayTimeRange($dayTime);
		$trainer_id = Yii::$app->user->identity->id;

		$user_tasks = UserTask::findAll([
			"id_user" => Yii::$app->user->identity->id,
		]);

		$user_tasks_selected_day_query = UserTask::find()
			->andWhere(["id_user" => $user->id])
			->andWhere("day_start_ts >= :daytime_start",[":daytime_start" => $dayTimerange['begin'] ])
			->andWhere("day_end_ts <= :daytime_end",[":daytime_end" => $dayTimerange['end'] ]);
		$json_calendar = $this->generateJsonWithUserTasksAndTrainings($user_tasks);

		$data = [
			'selectedDayTime' => $dayTime,
			'user_tasks_selected_day' => $user_tasks_selected_day_query->all(),
			'json_calendar' => $json_calendar,
			'action_url' => Url::to(['index.php/trainings/new']),
			'return_url' => Url::to(['index.php/trainings?id_user=']),
		];
		return $this->render('tasks-calendar', $data);
	}

	private function generateJsonWithUserTasksAndTrainings($userTasks)
	{
		$arr = [];
		foreach ($userTasks as $userTask) {
			$array = (object)array(
				"name" => 'ad',
				"date" => date('Y-m-d', $userTask->day_start_ts),
				"id" => $userTask->id,
			);

			array_push( $arr, $array );
		}

		return json_encode($arr);
	}

	public function generateCalendarData($record)
	{
		$taskCalendar = [];
		foreach ($record as $training) {
			$trainings_notes = [];
			if ($training->trainingsNote) {
				foreach ($training->trainingsNote as $note) {
					$result = array(
						"title" => $note['title'],
						"description" => $note['description'],
					);
					array_push( $trainings_notes, $result );
				}
			}
			$content = array(
				date('H:i', $training['start_ts']),
				$training['title'],
				$training['description'],
				$training->user['first_name'] ." ". $training->user['last_name'],
				$trainings_notes,
			);
			array_push( $taskCalendar, $content );
		}
		return json_encode($taskCalendar);
	}

	public function actionGetRecordById()
	{
		$post_request = Yii::$app->request->post();


		if ( isset($post_request['id_array']) ) {
			$trainings_model = Trainings::find()->where(['id' => $post_request['id_array'] ])->orderBy('start_ts')->all();

			if ($trainings_model) {
				$json_data = $this->generateCalendarData($trainings_model);
				return $json_data;
			} else {
				return false;
			}
		}
	}

	public function actionGetUserTasksAsHtml()
	{
		$user = Yii::$app->user->identity;

		$training_ids = Yii::$app->request->post('trainings_ids');
		$day_time = Yii::$app->request->post('day_time');

		if ( $day_time == null ) {
			$day_time = time();
		}

		$user_tasks_selected_day = UserTask::find()
			->andWhere(["id_user" => $user->id])
			->andWhere("day_start_ts <= :day_time", [":day_time" => $day_time])
			->andWhere("day_end_ts >= :day_time", [":day_time" => $day_time]);

		$user_tasks_view = $this->renderAjax("/user-tasks/_selected-day-list",[
			'selectedDayTime' => $day_time,
			'user_tasks' => $user_tasks_selected_day->all(),
		]);

		$trainings_view = null;


			$trainings = Trainings::find()->where(['id' => $training_ids ])->orderBy('start_ts')->all();

			$trainings_view = $this->renderAjax("_trainings_list.php",[
				'trainings' => $trainings,
			]);
		// }

		return $this->asJson([
			'user_tasks' => $user_tasks_view,
			'trainings' => $trainings_view,
		]);
	}

	public function actionGetUserTasks(){
		$post_request_time = Yii::$app->request->post('time');
		$dayTimerange = \app\helpers\TimeHelper::getDayTimeRange($post_request_time);
		$user_tasks_selected_day_query = UserTask::find()
			->andWhere(["id_user" => Yii::$app->user->identity->id])
			->andWhere("day_start_ts >= :daytime_start",[":daytime_start" => $dayTimerange['begin'] ])
			->andWhere("day_end_ts <= :daytime_end",[":daytime_end" => $dayTimerange['end'] ]);

		$respond = Yii::$app->view->renderFile("@app/views/user-tasks/_selected-day-list.php",[
			'selectedDayTime' => $post_request_time,
			'user_tasks' => $user_tasks_selected_day_query->all(),
		]);
		return $respond;

		// return $json_calendar;
	}


}

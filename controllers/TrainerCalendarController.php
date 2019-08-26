<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\UsersCalendarAvailability;
use app\controllers\ApplicationController;
use app\models\Activities;
use yii\helpers\Url;
use app\models\Places;
use app\models\Trainings;
use app\models\TrainingsNotes;
use app\models\UsersPlaces;
use app\models\TrainersHasClients;
use app\helpers\ApplicationHelper;

class TrainerCalendarController extends ApplicationController
{
	public function beforeAction($action)
	{
		if ( Yii::$app->user->identity && Yii::$app->user->identity->admin == User::ADMIN_LEVEL || Yii::$app->user->identity && Yii::$app->user->identity->type == User::COACH_LEVEL) {
			// if ($action->id == 'load-events') {
			// }
			$this->enableCsrfValidation = false;
			return parent::beforeAction($action);
		}
		else{
			Yii::$app->response->statusCode = 404;
			echo "resource not found";
			$this->redirect(Url::to(['/login']));
			Yii::$app->end();
		}
	}

	public function actionIndex(){
		$trainer_id = Yii::$app->user->identity->id;
		$trainer = Yii::$app->user->identity;
		$trainerClients = TrainersHasClients::find()->where(['id_trainer' => $trainer_id ])->all();
		$clients = [];
		foreach ($trainerClients as $client) {
			array_push($clients, ['key' => $client->id_user, 'label' => $client->client['first_name'] . ' ' . $client->client['last_name']]);
		}
		$data =[
			'clients' => json_encode($clients),
		];

		return $this->render('index', $data);
	}

	public function actionLoadEvents(){
		$trainings = Trainings::find()->where(['id_coach' => Yii::$app->user->identity->id])->all();
		$trainings = $this->trainingApiGenerator($trainings);
		return json_encode($trainings);
	}

	public function actionCalendarAddEvent(){
		$post_request = Yii::$app->request->post();
		$trainings_model = new Trainings();
		$trainings_model->id_coach = Yii::$app->user->identity->id;
		$trainings_model->id_user = $post_request['event']['type'];
		$trainings_model->title = $post_request['event']['text'];
		$trainings_model->start_ts = $post_request['event']['start_unix_date'];
		$trainings_model->end_ts = $post_request['event']['end_unix_date'];
		if ($trainings_model->validate()) {
			$trainings_model->save();
			$data_respond = array(
					'new_id' => $trainings_model->id,
					'client_id' => $post_request['id'],
			);
			return json_encode($data_respond);
		}else{
			return false;
		}
	}

	private function trainingApiGenerator($model)
	{
		$taskCalendar = [];
		foreach ($model as $training):
					$array = (object)array(
								"id" => $training->id,
								'start_date' => date('Y-m-d G:i', $training['start_ts']),
								'end_date' => date('Y-m-d G:i', $training['end_ts']),
								"text" => $training->title,
								"title" => $training->user['first_name']. ' ' . $training->user['last_name'],
								"description" => $training->description,
								"event_type" => "training",
								"type" => $training->user['id']
							);

				array_push( $taskCalendar, $array );
		 endforeach;

		return $taskCalendar;
	}

	public function actionDeleteEvent(){
		$post_request = Yii::$app->request->post();

		if ( isset($post_request['id']) ) {
			if ( Trainings::deleteAll(['id_coach' => Yii::$app->user->identity->id, 'id' => $post_request['id']]) ) {
				return true;
			}
		}
		return false;
	}

	public function actionUpdateEvent()
	{
		$post_request = Yii::$app->request->post('event');
		$trainings_object = new Trainings();
		$trainings_model = $trainings_object->find()->
												where(['id_coach' => Yii::$app->user->identity->id, 'id' => 	$post_request['id'] ])
												->orderBy('id')
												->one();

			$trainings_model->title = $post_request["text"];
			$trainings_model->id_user = $post_request["type"];
			$trainings_model->start_ts =  $post_request["start_unix_date"];
			$trainings_model->end_ts =  $post_request["end_unix_date"];
			$trainings_model->description = $post_request["description"];

		if ($trainings_model->validate()) {
			$trainings_model->save();
		}
	}

}

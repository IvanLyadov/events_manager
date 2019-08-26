<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\controllers\ApplicationController;
use app\models\User;
use app\models\UserTask;
use yii\helpers\Url;
use app\helpers\ApplicationHelper;
use yii\filters\VerbFilter;
use yii\data\Pagination;


class UserTasksController extends ApplicationController
{
	private $crsfDisabledActions = ['index'];

	public function beforeAction($action)
	{
		if (in_array($action->id, $this->crsfDisabledActions))
		{
			$this->enableCsrfValidation = false;
		}

		return parent::beforeAction($action);
	}

	public function actionIndex()
	{
		$user = Yii::$app->user->identity;
		$userTasks = UserTask::findAll([
			'id_user' => $user->id,
		]);


		$data = [
			'userTasks' => $userTasks,
			'url_old_tasks' => "old-tasks"
		];
	}


	public function actionNew()
	{
		$user = Yii::$app->user->identity;

		$userTask = new UserTask();

		$data = [
			'userTask' => $userTask,
			'action' => Url::to(['user-tasks/create']),
			"back_url" => Url::to(["trainings/tasks"]),
		];


		return $this->render("new", $data);
	}
	public function actionCreate()
	{
		$user = Yii::$app->user->identity;
		$userTask = new UserTask();
		$userTask->load( Yii::$app->request->post() );
		$userTask->assignOwner( $user );
		$userTask->save();

		return $this->redirect(Url::to(["/trainings/tasks"]));
	}

	public function actionEdit($task_id)
	{
		$user = Yii::$app->user->identity;
		$userTask = UserTask::findOne([
			"id" => $task_id,
			"id_user" => $user->id,
		]);

		if ( $userTask === null )
		{
			return $this->redirect( Url::to(["/trainings/tasks"]) );
			exit;
		}

		$data = [
			'userTask' => $userTask,
			'action' => Url::to(['user-tasks/save']),
			"back_url" => Url::to(["trainings/tasks"]),
		];

		$data['back_url'] = Yii::$app->request->get('module_url') ? Yii::$app->request->get('module_url') : Url::to(["trainings/tasks"]);
		return $this->render("new", $data);

	}

	public function actionSave()
	{
		$user = Yii::$app->user->identity;
		$task_id = Yii::$app->request->post("UserTask")['id'];

		$userTask = UserTask::findOne([
			"id" => $task_id,
			'id_user' => $user->id,
		]);

		if ( $userTask )
		{
			$userTask->load( Yii::$app->request->post() );
			$userTask->save();
		}

		if (Yii::$app->request->post("module_url")) {
			return $this->redirect(Url::to([ '/trainings/tasks' ]));
		}
		return $this->redirect(Url::to(["/trainings/tasks"]));
	}

	public function actionDelete($task_id, $module_url = null)
	{
		$user = Yii::$app->user->identity;
		$userTask = UserTask::findOne([
			'id' => $task_id,
			'id_user' => $user->id,
		]);

		if ( $userTask != null )
		{
			$userTask->delete();
		}

		if ($module_url) {
			return $this->redirect($module_url);
		}
		return $this->redirect(Url::to(["/trainings/tasks"]));
	}

	public function actionMarkAsClosed($task_id, $module_url = null)
	{
		$user = Yii::$app->user->identity;

		$userTask = UserTask::findOne([
			'id' => $task_id,
			'id_user' => $user->id,
		]);

		if ( $userTask != null )
		{
			$userTask->is_open = 0;
			$userTask->save();
		}
		if ($module_url) {
			return $this->redirect('/trainings/tasks');
		}
		return $this->redirect(Url::to(["/trainings/tasks"]));
	}

	public function actionMarkAsOpen($task_id)
	{
		$user = Yii::$app->user->identity;
		$userTask = UserTask::findOne([
			'id' => $task_id,
			'id_user' => $user->id,
		]);

		if ( $userTask != null )
		{
			$userTask->is_open = 1;
			$userTask->save();
		}

		return $this->redirect(Url::to(["/trainings/tasks"]));
	}

	public function actionShowTasksList()
	{
		$user = Yii::$app->user->identity;

		$request = Yii::$app->request;
		$orderByDate = '';
		$searchByDate = '';
		$searchByText = '';

		$userTask = UserTask::find()
			->where([
				'id_user' => $user->id,
				'is_open' => 1,
			])
			->orderBy('day_start_ts ASC');



		if ($request->get('dateOrder') AND (strtoupper($request->get('dateOrder')) == 'ASC' OR strtoupper($request->get('dateOrder')) == 'DESC')) {
			$userTask
				->orderBy('day_start_ts ' . strtoupper($request->get('dateOrder')));
			$orderByDate = strtoupper($request->get('dateOrder'));
		}
		if ($request->get('date')) {
			$userTask
				->andFilterWhere(['>=', 'day_start_ts', strtotime($request->get('date'))]);
			$searchByDate = $request->get('date');
		}
		if ($request->get('search')) {
			$userTask
				->andFilterWhere([
					'or',
					['like', 'title', $request->get('search')],
					['like', 'description', $request->get('search')],
				]);
			$searchByText = $request->get('search');
		}

		$pagination = new Pagination(['totalCount' => $userTask->count(),'defaultPageSize' => 15]);
		$userTasks = $userTask->offset($pagination->offset)->limit($pagination->limit)->all();

		$data = [
			'userTasks' => $userTasks,
			'pagination' => $pagination,
			"back_url" => Url::to(["trainings/tasks"]),
			'orderByDate' => $orderByDate,
			'searchByDate' => $searchByDate,
			'searchByText' => $searchByText,
		];
		return $this->render("tasks-list", $data);
	}

}

<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Trainings;
use app\controllers\ApplicationController;
use yii\helpers\Url;
use app\models\User;
use app\models\TrainingsNotes;
use yii\base\ErrorException;
use yii\data\Pagination;


class TrainerDashboardController extends ApplicationController
{
	public function beforeAction($action)
	{
		if ( Yii::$app->user->identity && Yii::$app->user->identity->admin == User::ADMIN_LEVEL || Yii::$app->user->identity && Yii::$app->user->identity->type == User::COACH_LEVEL) {
			return parent::beforeAction($action);
		}
		elseif(Yii::$app->user->identity && Yii::$app->user->identity->admin == User::USER_LEVEL){
			$this->redirect(Url::to(['/user/dashboard']));
		}
		else{
			Yii::$app->response->statusCode = 404;
			echo "resource not found";
			$this->redirect(Url::to(['/login']));
			Yii::$app->end();
		}
	}

	public function actionIndex()
	{
		$id_user = Yii::$app->user->identity->id;

		$trainings_records = Trainings::find()
		->where(['id_coach' => $id_user])
		->orderBy('start_ts')
		->all();



		$data = [
			// 'pagination' => $pagination,
			'trainings_records' => $trainings_records,
			'get_back_url' => Url::to(['index.php/clients']),
			'edit_url' => Url::to(['index.php/trainings/edit', 'id_user' => $id_user]),
			'delete_url' => Url::to(['index.php/trainings/delete', 'id_user' => $id_user]),
			'add_url' => Url::to(['index.php/trainings/new?id_user='.$id_user]),
			'add_note_url' => Url::to(['index.php/trainings_notes/new?id_user='.$id_user]),
			'show_note_url' => Url::to(['index.php/trainings_notes/show_note?id_user='.$id_user]),
		];
		return $this->render('index', $data);
	}

}

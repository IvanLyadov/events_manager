<?php

namespace app\controllers;

use Yii;
//use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\User;
use app\models\UsersImages;
use app\helpers\ApplicationHelper;
use app\controllers\ApplicationController;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\data\Pagination;


class UsersImagesController extends ApplicationController
{
	public function __construct($id, $module, $config = [])
	{
		// if (isset(Yii::$app->user->identity->type) && Yii::$app->user->identity->type != 'coach') {
		// 	die();
		// }

		parent::__construct($id, $module, $config);
	}

	public function actionIndex()
	{
		$user_status = Yii::$app->user->identity->type;
		// if ($user_status != 'coach') {
		// 	return false;
		// }
		$id_traner = Yii::$app->user->identity->id;
		$users_images_records = UsersImages::find()
		->where(['id_user' => $id_traner])
		->orderBy('id DESC');

		$pagination = new Pagination(['totalCount' => $users_images_records->count(),'defaultPageSize' => 35]);
		$users_images_pagination = $users_images_records->offset($pagination->offset)->limit($pagination->limit)->all();


		$data = [
			'pagination' => $pagination,
			'trainer_images' => $users_images_pagination,
			'add_url' => Url::to(['index.php/gallery/new']),
			'profile_places' => Url::to(['index.php/profile/places']),
		];
		return $this->render('index', $data);
	}

	public function actionAddFiles()
	{
		$user_id = Yii::$app->user->identity->id;
		$users_images_model = new UsersImages();
		$users_images_records = UsersImages::find()
		->where(['id_user' => $user_id])
		->orderBy('id DESC');

		$pagination = new Pagination(['totalCount' => $users_images_records->count(),'defaultPageSize' => 30]);
		$users_images_pagination = $users_images_records->offset($pagination->offset)->limit($pagination->limit)->all();

		$data = [
				'users_images_records' => $users_images_pagination,
				'pagination' => $pagination,
				'users_images_model' => $users_images_model,
				'form_action' => Url::to(['index.php/gallery/new']),
				'return_url' => Url::to(['index.php/gallery']),
				'action_controller' => Url::to(['index.php/gallery/delete_images']),
			];
		return $this->render('add-files', $data);
	}

	public function actionSave()
	{
		$user_id = Yii::$app->user->identity->id;
		$users_images_model = new UsersImages();
		$users_images_model->load( Yii::$app->request->post() );

		$users_images_model->imageFiles = UploadedFile::getInstances($users_images_model, 'imageFiles');

		foreach ($users_images_model->imageFiles as $file){
			$users_images = new UsersImages();

			$applicationHelper = new ApplicationHelper();
			$fileName = $applicationHelper->replace_pl_str_to_en($file->baseName) . $users_images->generateRandomInt(5) . '_'. time() . '.' . $file->extension;
			$users_images->image = $fileName;
			$users_images->id_user = $user_id;
			// $users_images->validate();
			$users_images->save(false);


			$file->saveAs('uploads/gallery/' . $fileName);
		}
		return $this->redirect(Url::to(['index.php/gallery/new']));
	}

	public function actionDeleteImages()
	{
		$user_id = Yii::$app->user->identity->id;
		$images_request = Yii::$app->request->post();
		if (isset($images_request['delete-event'])) {
			$user_images_model = UsersImages::deleteAll(['id' => $images_request['images_checked'], 'id_user' => $user_id ]);
			if ( $user_images_model ) {
					Yii::$app->session->setFlash('user_message', "Zdjięcia zostałi usunięte");
				return $this->redirect( Url::to(['index.php/gallery/new']) );
			}
		}
	}

}

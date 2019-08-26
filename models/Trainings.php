<?php

namespace app\models;

use yii;

use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;
use app\models\User;
use app\models\Places;
use app\models\TrainingsNotes;

class Trainings extends ActiveRecord
{
	public $training_date;
	

	public static function tableName()
	{
		return "trainings";
	}

	public function rules()
	{
		return [
			[
				['id_user', 'id_coach', 'title', 'description', 'created_ts', 'end_ts', 'start_ts', 'training_date'],
				'safe'
			],
		];
	}

	public function beforeSave ( $insert)
	{
		return parent::beforeSave($insert);
	}

	public function afterSave($insert, $changedAttributes)
	{
		return parent::afterSave($insert, $changedAttributes);
	}

	public function getTrainingsNote()
	{
		return $this->hasMany(TrainingsNotes::className(), ['id_training' => 'id']);
	}

	public function getTrainingNote()
	{
		return $this->hasOne(TrainingsNotes::className(), ['id_training' => 'id']);
	}

	// public function getClientTrainingsNote()
	// {
	// 	return $this->hasMany(TrainingsNotes::className(), ['id_training' => 'id']);
	// }

	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'id_user']);
	}
	public function getTrainer()
	{
		return $this->hasOne(User::className(), ['id' => 'id_coach']);
	}
	// public function getPlace()
	// {
	// 	return $this->hasOne(Places::className(), ['id' => 'id_place']);
	// }

}

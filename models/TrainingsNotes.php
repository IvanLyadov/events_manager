<?php
namespace app\models;
use yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;
use app\models\ActivitiesGroups;
use app\models\Trainings;

class TrainingsNotes extends ActiveRecord
{

	public static function tableName()
	{
		return "trainings_notes";
	}

	public function rules()
	{
		return [
			[
				['id_training', 'description', 'title', 'created_ts', 'public'],
				'safe'
			],
		];
	}

	//public $created_ts;

	public function beforeSave ( $insert)
	{
		return parent::beforeSave($insert);
	}

	public function afterSave($insert, $changedAttributes)
	{
		return parent::afterSave($insert, $changedAttributes);
	}

	public function getTraining()
	{
		return $this->hasOne( Trainings::className(), ['id' => 'id_training'] );
	}

}

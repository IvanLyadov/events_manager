<?php

namespace app\models;

use yii;

use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;
use app\models\User;

class TrainersHasClients extends ActiveRecord
{

	public static function tableName()
	{
		return "trainers_has_clients";
	}

	public function rules()
	{
		return [
			[
				['id_trainer', 'id_user'],
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

	public function getClient()
	{
		return $this->hasOne( User::className(), ['id' => 'id_user'] );
	}

}

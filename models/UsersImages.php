<?php

namespace app\models;

use yii;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\Url;
use yii\web\UploadedFile;
use app\models\ClubsTrainers;


class UsersImages extends ActiveRecord
{
	public $imageFiles;
	public static function tableName()
	{
		return "users_images";
	}

	public function rules()
	{
		return [
				[['id_user', 'image'], 'safe'],
				[['imageFiles'],'file',
					'maxFiles' => 5,
					'skipOnEmpty' => false,
					'extensions' => 'png, jpg',
					'wrongExtension'=> 'Zły format pliku: png, jpg',
					'maxSize'=>1024 * 1024 * 2,
					'tooBig'=>'Maksymalna wielkość pliku: 2MB'
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

	public function getTrainersParticipants()
	{
		return $this->hasMany(ClubsTrainers::className(), ['id_club' => 'id'])
				->where(['confirmed' => 1])
				->orderBy('id');

	}

	public function getTrainersApplicants()
	{
		return $this->hasMany(ClubsTrainers::className(), ['id_club' => 'id'])
					->where(['confirmed' => 0])
					->orderBy('id');
	}

	public function getTrainersApplicantsCount()
	{
		return $this->hasMany(ClubsTrainers::className(), ['id_club' => 'id'])
					->where(['confirmed' => 0])
					->count();
	}
	public function getTrainer($user_id)
	{
		return $this->hasOne(ClubsTrainers::className(), ['id_club' => 'id'])
					->where(['id_user' => $user_id, "confirmed" => 1 ])
					->orderBy('id');
	}
	public function getManager()
	{
		return $this->hasOne(User::className(), ['id' => 'id_user']);
					// ->where(['id_user' => $user_id, "confirmed" => 1 ])
					// ->orderBy('id');
	}

	public static function getValidateManager($id){
		$manager = self::findOne(['id_user' => $id]);

		return $manager;
	}





	/**
	 * Finds an identity by the given ID.
	 *
	 * @param string|int $id the ID to be looked for
	 * @return IdentityInterface|null the identity object that matches the given ID.
	 */
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	/**
	 * Finds an identity by the given token.
	 *
	 * @param string $token the token to be looked for
	 * @return IdentityInterface|null the identity object that matches the given token.
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['access_token' => $token]);
	}

	/**
	 * @return int|string current user ID
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string current user auth key
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @param string $authKey
	 * @return bool if auth key is valid for current user
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	public function encryptPass($password)
	{
		return md5($password);
	}

	public function resetPassword($user){}

	public function generateRandomInt($length)
	{
		return rand(pow(10, $length-1), pow(10, $length)-1);
	}


}

<?php
namespace app\models;
use yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\base\ErrorException;
use app\models\UserTask;
use app\models\UsersCalendarAvailability;
use app\models\Trainings;


class User extends ActiveRecord implements IdentityInterface
{
	const ADMIN_LEVEL = 1;
	const SCENARIO_CREATED_BY_TRAINER = 'created_by_trainer';
	const SCENARIO_TRAINER_ACCOUNT_REGISTER = 'trainer_account_register';
	const SCENARIO_PASSWORD_EDIT = 'password_edit';

	public $passwordConfirm;
	public $passwordChange;
	public $passwordRepeat;
	public $userFiles;

	public static function tableName()
	{
		return "users";
	}

	public function rules()
	{
		return [
				// On register
				[
					['email', 'password', 'first_name', 'last_name', 'phone'],
					'required',
					'on' => 'register',
					'message' => 'Pole jest wymagane'
				],
				[
					['email', 'password', 'first_name', 'last_name', 'phone'],
					'required',
					'message' => 'Pole nie może być puste',
					'on' => self::SCENARIO_PASSWORD_EDIT
				],
				[
					'email',
					'unique',
					'targetAttribute' => 'email',
					'on' => 'register',
					'message' => 'Konto z takim adresem już istnieje'
				],
				[
					['passwordConfirm'],
					'compare',
					'on' => 'register',
					'compareAttribute' => 'password',
					'message' => 'Hasło musi zawierać min. 8 znaków. Hasła muszą się zgadzać.'
				],
				[
					['email'],
					'email',
					'message' => "Niepoprawny format email"
				],
				[
					['passwordConfirm'], 'safe'
				],

				[
					['passwordChange'],
					'required',
					'message' => 'Pole nie może być puste.',
					'on' => self::SCENARIO_PASSWORD_EDIT,
				],

				[
					['passwordChange'],
					'string',
					'min' => 8,
					'tooShort' => 'Hasło musi zawierać min. 8 znaków.',
				],

				[
					['passwordRepeat'],
					'required',
					'message' => 'Pole nie może być puste.',
					'on' => self::SCENARIO_PASSWORD_EDIT,
				],

				[
					['passwordRepeat'],
					'compare',
					'compareAttribute' => 'passwordChange',
					// 'on' => 'register',
					'message' => 'Hasła muszą się zgadzać.',
				],

				[
					['activation_token', 'active', 'first_name', 'last_name', 'description', 'experience', 'phone', 'avatar_image', 'id_trainer', 'timeNotification'],
					'safe'
				],
				[
					['active'],
					'default',
					'value' => 1,
					'on' => self::SCENARIO_CREATED_BY_TRAINER,
				],
				[
					['type'],
					'default',
					'value' => "user",
					'on' => self::SCENARIO_CREATED_BY_TRAINER,
				],
				[
					['userFiles'],
					'file',
					'skipOnEmpty' => true,
					'extensions' => 'png, jpeg, jpg','maxFiles' => 1,
					'wrongExtension'=> 'Zły format pliku: png, jpg',
					'maxSize'=> 1024 * 1024 * 2,
					'tooBig'=>'Maksymalna wielkość pliku: 2MB'
				],
				[
					['userFiles'],
					'image',
					'skipOnEmpty' => true,
					'extensions' => 'png, jpeg, jpg','maxFiles' => 1,
					'wrongExtension'=> 'Zły format pliku: png, jpg',
					'maxSize'=> 1024 * 1024 * 2,
					'tooBig'=>'Maksymalna wielkość pliku: 2MB',
				],
				[
					['phone'],
					'match',
					'on' => 'register',
					'pattern' => '/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$/',
					'message' => 'Nie poprawny format telefonu'
				],
			];
	}

	public static function userInGroup($config = [])
	{
		$instance = self::find()->where($config);
	}

	public function upload()
	{
		 if ( $this->validate() )
		{
			if ($this->userFiles){
				$filename = time()."_".$this->generateRandomInt(4)."_".$this->generateRandomInt(4) . '.' . $this->userFiles->extension;
				$this->userFiles->saveAs('uploads/user_files/' . $filename);

				$user = $this->findOne(Yii::$app->user->identity->id);
				$user->avatar_image = $filename;
				$user->save();
			}
			return true;
		}
		else {
			return false;
		}
	}

	public function beforeSave ( $insert)
	{
		if ($insert) {
			$this->created_ts = time();
			$this->activation_token = hash( 'sha256', $this->email.time().rand(1000, 9999));
		}
		else
		{
			$this->edited_ts = time();
		}

		return parent::beforeSave($insert);
	}

	public function afterSave($insert, $changedAttributes)
	{
		return parent::afterSave($insert, $changedAttributes);
	}

	public function sendEmailAfterSave()
	{
		$conf = [
			'email' => $this->email,
			'token' => $this->activation_token,
			'timestamp' => time(),
		];

		$token = serialize ($conf);
		$token_encoded = base64_encode($token);

		$email_messege = '<table><tr><td>Witaj '. $this->first_name . " " . $this->last_name .' w serwisie KalendarzTrenera.pl<br>Dla zakończenia rejestracji proszę przejśc do linku podany niżej:</td></tr><tr><td><a href="'.Url::to('@web/index.php/useractivation?token='.$token_encoded, true).'">'.Url::to('@web/index.php/useractivation/'.$token_encoded, true).'</a>
		<br>Jeśli nie zakładałeś konta w naszym serwisie daj nam o tym znać na adres <a href="mailto:bok@trenujdlasiebie.pl">bok@trenujdlasiebie.pl</a> lub zignoruj tę wiadomość.<br>Z poważaniem Załoga Serwisu <a href="http://tds.seraaq.com">KalendarzTrenera.pl</a> </td></tr></table>';
		$this->sendEmail( 'no-reply@tds.com', $this->email, 'Rejestracja użytkownika', '', $email_messege);
	}

	public function sendEmail($from = NULL, $to, $subject = NULL, $body, $htmlbody = NULL)
	{
		$succesRecipientsCount = 0;
		$mailer = Yii::$app->mailer;

		$succesRecipientsCount = $mailer
			->compose()
			->setFrom( $from )
			->setTo( $to )
			->setBcc ("archiwum@trenujdlasiebie.pl")
			->setSubject( $subject )
			->setTextBody( $body )
			->setHtmlBody($htmlbody)
			->send();

		return $succesRecipientsCount;
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

	static function encryptPass($password)
	{
		return md5($password);
	}

	public function resetPassword($user){}

	public function generateRandomInt($length)
	{
		return rand(pow(10, $length-1), pow(10, $length)-1);
	}

	public function uniqueEmail($attribute)
	{
		$user = static::findOne(['email' => $attribute]);
		if ($user) {
			return true;
		}
		return false;
	}
	public function generateToken()
	{
		return hash('sha256', $this->email.time().rand(1000, 9999));
	}

	public function generateRandomString()
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 10; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	public function getFullName()
	{
		return $this->first_name . " " . $this->last_name;
	}

	public function getClients()
	{
		return $this->hasMany(User::className(), ['id' => 'id_user'])
					->viaTable('trainers_has_clients', ['id_trainer' => 'id']);
	}

	public function getTrainers()
	{
		return $this->hasMany(User::className(), ['id' => 'id_trainer'])
					->viaTable('trainers_has_clients', ['id_user' => 'id']);
	}

	public function isAssignedToTrainer($trainer)
	{
		return $trainer->getClients()->where(['id' => $this->id])->exists();
	}

	public function assignTrainer($trainer)
	{
		$this->link('trainers', $trainer);
	}

	public function unAssignTrainer($trainer)
	{
		$this->unlink('trainers', $trainer, true);
	}

	public function unAssignClient($user)
	{
		$this->unlink('clients', $user, true);
	}

	public function notifyAboutAssignmentToTrainer($trainer)
	{

		Yii::$app->mailer->compose('user-assigned-to-trainer', [
			'user' => $this,
			'trainer' => $trainer,
		])
		->setFrom('no-reply@admin.com')
		->setTo($this->email)
		->setSubject('Zostałeś przypisany do trenera')
		->send();
	}

	public function getActivationLink()
	{
		$conf = [
			'email' => $this->email,
			'token' => $this->activation_token,
			'timestamp' => time(),
		];
		$token = serialize ($conf);
		$token_encoded = base64_encode($token);
		return Url::to('@web/index.php/useractivation?token='.$token_encoded, true);
	}

	public function sendActivationEmail()
	{
		Yii::$app->mailer->compose('account-activation', [
			'user' => $this,
		])
		->setFrom('no-reply@tds.com')
		->setTo($this->email)
		->setSubject('Aktywuj konto w systemie TDS')
		->send();
	}

	public function notifyAboutAccountCreatedByTrainer($trainer, $unencrypted_password)
	{
		Yii::$app->mailer->compose('account-creation-by-trainer', [
			'user' => $this,
			'trainer' => $trainer,
			'password' => $unencrypted_password,
		])
		->setFrom('no-reply@tds.com')
		->setTo($this->email)
		->setSubject('Twoje konto w systemie TDS')
		->send();
	}

	public static function generateRandomPassword($seed="")
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 10; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	public function getTrainings()
	{
		return $this->hasMany(Trainings::className(), ['id_user' => 'id']);
	}


}

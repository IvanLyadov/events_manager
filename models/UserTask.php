<?php
namespace app\models;
use yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use app\models\User;

class UserTask extends ActiveRecord
{
	const DATE_FORMAT = "DD-MM-YYYY";

	public static function tableName()
	{
		return "user_tasks";
	}

	public function rules()
	{
		return [
			[
				[
					'id_user',
					'title',
					'description',
					'day_start_ts',
					'day_end_ts',
				],
				'default',
			],
			[
				'is_open',
				'default',
				'value' => 1,
			],
			[
				['selectedDay'],
				'safe'
			]
		];
	}

	public function beforeSave ( $insert)
	{
		if ( parent::beforeSave($insert) )
		{
			if ( $this->selectedDateIsValid($this->selectedDay) )
			{
				$this->createDayTimeFromSelectedDate();
			}
			else{
				$this->createDayTimeFromSelectedDateUnterminated();
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	public function afterSave($insert, $changedAttributes)
	{
		return parent::afterSave($insert, $changedAttributes);
	}

	public function setSelectedDay($selectedDay)
	{
		$this->selectedDay = $selectedDay;
	}

	public function getSelectedDay()
	{
		if ( $this->day_start_ts )
		{
			return $this->getDayTimeFromSelectedDate();
		}
		else
		{
			return null;
		}
	}

	public function selectedDateIsValid($date, $format = "d-m-Y")
	{
		$d = \DateTime::createFromFormat($format, $date);

		return $d && $d->format($format) == $date;
	}

	public function assignOwner( \app\models\User $user )
	{
		$this->id_user = $user->id;
	}

	public function userIsOwner( \app\models\User $user )
	{
		return $this->id_user === $user->id;
	}

	public function markAsClosed()
	{
		$this->is_open = 0;
	}

	private function createDayTimeFromSelectedDate()
	{
		$this->day_start_ts = strtotime( $this->selectedDay. " 00:00:00" );
		$this->day_end_ts = strtotime( $this->selectedDay. " 23:59:59" );
	}

	private function createDayTimeFromSelectedDateUnterminated()
	{
		$this->day_start_ts = '2000000000';
		$this->day_end_ts = '2000000000';
	}

	public function getDayTimeFromSelectedDate($format = "d-m-Y")
	{
		return date( $format, $this->day_start_ts );
	}


	public function getOwner()
	{
		return $this->hasOne(User::className(), ['id' => 'id_user']);
	}


}

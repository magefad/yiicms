<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * @var int
	 */
	private $_id;

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		/** @var $user User */
		$user = User::model()->findByAttributes(array('username' => $this->username));
		if ( $user === null )
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		else if ( !$user->validatePassword($this->password) )#!$user->validatePassword($this->password
		{
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
		else
		{
			$this->_id      = $user->id;
			$this->username = $user->username;
			Yii::app()->user->setState('id', $user->id);
			Yii::app()->user->setState('access_level', $user->access_level);
			Yii::app()->user->setState('username', $user->username);
			Yii::app()->user->setState('email', $user->email);
			Yii::app()->user->setState('loginTime', time());

			if ( $user->access_level == User::ACCESS_LEVEL_ADMIN )
			{
				Yii::app()->user->setState('loginAdmTime', time());
				Yii::app()->user->setState('isAdmin', $user->access_level);
			}

			$user->last_visit = new CDbExpression('NOW()');
			$user->update(array('last_visit'));

			$this->errorCode = self::ERROR_NONE;
		}
		return $this->errorCode == self::ERROR_NONE;
	}


	public function getEmailConfirmStatusList()
	{
		return array(
			self::EMAIL_CONFIRM_YES => Yii::t('user', 'Да'),
			self::EMAIL_CONFIRM_NO  => Yii::t('user', 'Нет'),
		);
	}

	public function getEmailConfirmStatus()
	{
		$data = $this->getEmailConfirmStatusList();

		return isset($data[$this->email_confirm]) ? $data[$this->email_confirm] : Yii::t('user', 'неизвестно');
	}

	/**
	 * @return int|mixed|string
	 */
	public function getId()
	{
		return $this->_id;
	}


}
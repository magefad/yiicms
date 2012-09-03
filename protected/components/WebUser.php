<?php
/**
 * User: fad
 * Date: 17.07.12
 * Time: 15:11
 */
class WebUser extends CWebUser
{
	/**
	 * Авторизован ли пользователь
	 * @return bool
	 */
	public function isAuthenticated()
	{
		if ( Yii::app()->user->isGuest )
		{
			return false;
		}
		$authData = WebUser::getAuthData();
        if ( $authData['username'] && isset($authData['access_level']) && $authData['loginTime'] && $authData['id'] )
		{
			return true;
		}
		return false;
	}

	/**
	 * @return array username, access_level, loginTime, id
	 */
	protected function getAuthData()
	{
		return array(
			'username' => Yii::app()->user->getState('username'),
			'access_level' => (int)Yii::app()->user->getState('access_level'),
			'loginTime' => Yii::app()->user->getState('loginTime'),
			'id' => (int)Yii::app()->user->getState('id')
		);
	}

	/**
	 * @return bool is admin
	 */
	public function isSuperUser()
	{
		if ( !WebUser::isAuthenticated() )
		{
			return false;
		}
        $loginAdmTime = Yii::app()->user->getState('loginAdmTime');
		$isAdmin = Yii::app()->user->getState('isAdmin');

		if ( $isAdmin == User::ACCESS_LEVEL_ADMIN && $loginAdmTime )
		{
			return true;
		}
		return false;
	}
}

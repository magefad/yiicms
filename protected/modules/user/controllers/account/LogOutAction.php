<?php
/**
 * User: fad
 * Date: 06.09.12
 * Time: 18:34
 */
class LogOutAction extends CAction
{
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function run()
	{
		Yii::app()->user->logout();
		$this->controller->redirect(Yii::app()->getHomeUrl());
	}
}

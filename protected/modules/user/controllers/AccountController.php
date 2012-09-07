<?php
/**
 * User: fad
 * Date: 06.09.12
 * Time: 17:57
 */
class AccountController extends Controller
{
	public function actions()
	{
		return array(
			'captcha'   => array(
				'class' => 'CCaptchaAction', 'backColor' => 0xFFFFFF,
			),
			'login'  => array(
				'class' => 'application.modules.user.controllers.account.LoginAction',
			),
			'logout' => array(
				'class' => 'application.modules.user.controllers.account.LogOutAction',
			),
		);
	}
}

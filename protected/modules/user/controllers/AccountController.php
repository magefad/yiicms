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
            'captcha'      => array(
                'class'     => 'CCaptchaAction',
                'backColor' => 0xf5f5f5,
                'testLimit' => 3,
            ),
            'login'        => array(
                'class' => 'user.controllers.account.LoginAction',
            ),
            'logout'       => array(
                'class' => 'user.controllers.account.LogOutAction',
            ),
            'registration' => array(
                'class' => 'user.controllers.account.RegistrationAction',
            ),
            'activateEmail' => array(
                'class' => 'user.controllers.account.ActivateEmailAction',
            ),
        );
    }
}

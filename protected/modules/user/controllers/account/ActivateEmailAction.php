<?php
class ActivateEmailAction extends CAction
{
    public function run($key)
    {
        /** @var $user User */
        $user = User::model()->notActivated()->find('activate_key = :activate_key', array(':activate_key' => $key));

        if (!$user) {
            Yii::app()->user->setFlash('error', Yii::t('user', 'Ошибка активации! Возможно данный аккаунт уже активирован! Попробуете зарегистрироваться вновь?'));
            $this->controller->redirect(array('registration'));
        }
        if ($user->activate()) {
            Yii::log(
                Yii::t('user', "Активирован аккаунт с activate_key = {activate_key}!", array('{activate_key}' => $key)),
                CLogger::LEVEL_INFO,
                UserModule::$logCategory
            );
            Yii::app()->user->setFlash('success', Yii::t('user', 'Вы успешно подтвердили email адрес!'));
            if (Yii::app()->user->isGuest) {
                $this->controller->redirect(array('login'));
            } else {
                $this->controller->redirect(array('/user/profile'));
            }
        } else {
            Yii::app()->user->setFlash('error', Yii::t('user', 'При активации аккаунта произошла ошибка! Попробуйте позже!'));

            Yii::log(
                Yii::t('user', "При активации аккаунта c activate_key => {activate_key} произошла ошибка!", array('{activate_key}' => $key)),
                CLogger::LEVEL_ERROR,
                UserModule::$logCategory
            );

            $this->controller->redirect(array('login'));
        }
    }
}

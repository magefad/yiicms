<?php

class UserModule extends WebModule
{
    public function getName()
    {
        return Yii::t('user', 'Пользователи');
    }

    public function getDescription()
    {
        return Yii::t('user', 'Управление пользователями сайта');
    }

    public function getIcon()
    {
        return 'user';
    }

    public function init()
    {
        $this->setImport(
            array(
                'user.models.*',
                'user.components.*',
                'user.extensions.*'
            )
        );
    }
}

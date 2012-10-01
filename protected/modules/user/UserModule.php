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
                'user.extensions.eoauth.*',
                'user.extensions.eoauth.lib.*',
                'user.extensions.lightopenid.*',
                'user.extensions.eauth.*',
                'user.extensions.eauth.services.*',
                'user.extensions.eauth.custom_services.*',
            )
        );
        //load EAuth components
        Yii::app()->setComponents(
            array(
                'loid'  => array(
                    'class' => 'user.extensions.lightopenid.loid',
                ),
                'eauth' => require('config' . DIRECTORY_SEPARATOR . 'eauth.php')
            )
        );
    }
}

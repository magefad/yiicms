<?php

class UserModule extends WebModule
{
    public $minPasswordLength = 3;
    public $emailAccountVerification = true;
    public $showCaptcha = true;
    public $minCaptchaLength = 3;
    public $maxCaptchaLength = 6;

    public static $logCategory = 'application.modules.user';

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
                'ext.mail.YiiMailMessage',
            )
        );
        //load EAuth components
        Yii::app()->setComponents(
            array(
                'loid'  => array(
                    'class' => 'user.extensions.lightopenid.loid',
                ),
                'eauth' => require('config' . DIRECTORY_SEPARATOR . 'eauth.php'),
                'mail'  => array(
                    'class'         => 'ext.mail.YiiMail',
                    'transportType' => 'php',
                    'viewPath'      => 'user.views.mail',
                    'logging'       => true,
                    'dryRun'        => false
                )
            )
        );
    }

    public function isAllowedEmail($email)
    {
        if (is_array($this->emailBlackList) && count($this->emailBlackList)) {
            if (in_array(trim($email), $this->emailBlackList)) {
                return false;
            }
        }
        return true;
    }
}

<?php

class ContactModule extends WebModule
{
    /** @var bool */
    public $captchaRequired = true;

    /**
     * @var bool set From header for mail function
     */
    public $setFrom = 0;
    /**
     * @var string form class for DefaultController actionFull
     */
    public $fullFormClass = '';
    public $fullFormTitle = '';
    public $fullFormMessage = '';

    public $smtpEnabled = 0;
    public $smtpHost = 'smtp.yandex.ru';
    public $smtpPort = 465;
    public $smtpUserName = '';
    public $smtpPassword = '';
    public $smtpEncryption = 'ssl';

    public static function getName()
    {
        return Yii::t('ContactModule.contact', 'Contact form and mail settings');
    }

    public static function getDescription()
    {
        return Yii::t('ContactModule.contact', 'Module for sending messages from site');
    }

    public static function getIcon()
    {
        return 'envelope';
    }

    public function getSettingLabels()
    {
        return array(
            'captchaRequired' => Yii::t('ContactModule.contact', 'Required Captcha?'),
            'setFrom'         => Yii::t('ContactModule.contact', 'Set from email address'),
            'fullFormClass'   => Yii::t('ContactModule.contact', 'Full form class name'),
            'fullFormTitle'   => Yii::t('ContactModule.contact', 'Message title of full form'),
            'fullFormMessage' => Yii::t('ContactModule.contact', 'Alert text after send message from full form'),
            'smtpEnabled'     => Yii::t('ContactModule.contact', 'Enable send mail via SMTP?'),
            'smtpHost'        => Yii::t('ContactModule.contact', 'SMTP Server Host'),
            'smtpPort'        => Yii::t('ContactModule.contact', 'SMTP port'),
            'smtpUserName'    => Yii::t('ContactModule.contact', 'SMTP login'),
            'smtpPassword'    => Yii::t('ContactModule.contact', 'SMTP password'),
            'smtpEncryption'  => Yii::t('ContactModule.contact', 'SMTP type connection')
        );
    }

    public function getSettingData()
    {
        return array(
            'captchaRequired' => array(
                'data'        => $this->getChoice(), //yes no
                'tag'         => 'radioButtonListInline',
                'htmlOptions' => array(
                    'hint' => Yii::t('ContactModule.contact', 'Only for simple form. Anti-spam.') . ' (captcha)',
                )
            ),
            'setFrom'         => array(
                'data'        => $this->getChoice(), //yes no
                'tag'         => 'radioButtonListInline',
                'htmlOptions' => array(
                    'hint' => Yii::t('ContactModule.contact', 'For example disable on McHost.ru. Option worked only throw PHP mail(), not SMTP'),
                )
            ),
            'smtpEnabled'     => array(
                'data'        => $this->getChoice(), //yes no
                'tag'         => 'radioButtonListInline',
            ),
            'fullFormClass'   => array(
                'htmlOptions' => array(
                    'hint' => Yii::t('ContactModule.contact', 'Не меняйте, если не уверены')
                )
            )
        );
    }

    public function init()
    {
        /** read settings from DB */
        parent::init();
        if (empty($this->fullFormTitle)) {
            $this->fullFormTitle = Yii::t('ContactModule.contact', 'Опросный лист с сайта') . ' ' . Yii::app()->name;
        }
        if (empty($this->fullFormMessage)) {
            $this->fullFormMessage = Yii::t('ContactModule.contact', 'Thanks for message!');
        }
        $this->setImport(
            array(
                'contact.models.*',
                'ext.mail.YiiMailMessage',
                'page.PageModule'
            )
        );
        $config = array(
            'class'            => 'ext.mail.YiiMail',
            'transportType'    => $this->smtpEnabled ? 'smtp' : 'php',
            'viewPath'         => 'contact.views.mail',
            'logging'          => true,
            'dryRun'           => false
        );
        if ($this->smtpEnabled) {
            $config = array_merge(
                $config,
                array(
                    'host'       => $this->smtpHost,
                    'username'   => $this->smtpUserName,
                    'password'   => $this->smtpPassword,
                    'port'       => $this->smtpPort,
                    'encryption' => $this->smtpEncryption
                )
            );
        }
        Yii::app()->setComponents(array('mail' => $config));
    }
}

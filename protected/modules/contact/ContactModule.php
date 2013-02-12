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
        return Yii::t('contact', 'Форма обратной связи');
    }

    public static function getDescription()
    {
        return Yii::t('contact', 'Модуль для отправки сообщений с сайта');
    }

    public static function getIcon()
    {
        return 'envelope';
    }

    public function getSettingLabels()
    {
        return array(
            'captchaRequired' => Yii::t('contact', 'Требовать ввод кода с картинки'),
            'setFrom'         => Yii::t('contact', 'Указывать адрес отправителя'),
            'fullFormClass'   => Yii::t('contact', 'Имя класса полной версии формы'),
            'fullFormTitle'   => Yii::t('contact', 'Заголовок сообщения полной версии формы'),
            'fullFormMessage' => Yii::t('contact', 'Текст сообщений после отправки полной версии формы'),
            'smtpEnabled'     => Yii::t('contact', 'Включить отправку почты через SMTP?'),
            'smtpHost'        => Yii::t('contact', 'SMTP Адрес сервера'),
            'smtpPort'        => Yii::t('contact', 'SMTP порт'),
            'smtpUserName'    => Yii::t('contact', 'SMTP логин'),
            'smtpPassword'    => Yii::t('contact', 'SMTP пароль'),
            'smtpEncryption'  => Yii::t('contact', 'SMTP тип соединения')
        );
    }

    public function getSettingData()
    {
        return array(
            'captchaRequired' => array(
                'data'        => $this->getChoice(), //yes no
                'tag'         => 'radioButtonListInline',
                'htmlOptions' => array(
                    'hint' => Yii::t('contact', 'Только для простой формы. Используется для бобрьбы против спаммеров') . ' (captcha)',
                )
            ),
            'setFrom'         => array(
                'data'        => $this->getChoice(), //yes no
                'tag'         => 'radioButtonListInline',
                'htmlOptions' => array(
                    'hint' => Yii::t('contact', 'На примере хостинга McHost.ru рекоммендуется отключить. Опция действует ТОЛЬКО при отправке через PHP mail(), не SMTP'),
                )
            ),
            'smtpEnabled'     => array(
                'data'        => $this->getChoice(), //yes no
                'tag'         => 'radioButtonListInline',
            ),
            'fullFormClass'   => array(
                'htmlOptions' => array(
                    'hint' => Yii::t('contact', 'Не меняйте, если не уверены')
                )
            )
        );
    }

    public function init()
    {
        /** read settings from DB */
        parent::init();
        if (empty($this->fullFormTitle)) {
            $this->fullFormTitle = Yii::t('contact', 'Опросный лист с сайта') . ' ' . Yii::app()->name;
        }
        if (empty($this->fullFormMessage)) {
            $this->fullFormMessage = Yii::t('contact', 'Спасибо за сообщение! Мы Вам обязательно ответим!');
        }
        $this->setImport(
            array(
                'contact.models.*',
                'ext.mail.YiiMailMessage'
            )
        );
        Yii::app()->setComponents(
            array(
                'mail' => array(
                    'class'            => 'ext.mail.YiiMail',
                    'transportType'    => $this->smtpEnabled ? 'smtp' : 'php',
                    'transportOptions' => array(
                        'host'       => $this->smtpHost,
                        'username'   => $this->smtpUserName,
                        'password'   => $this->smtpPassword,
                        'port'       => $this->smtpPort,
                        'encryption' => $this->smtpEncryption,
                    ),
                    'viewPath'         => 'contact.views.mail',
                    'logging'          => true,
                    'dryRun'           => false
                )
            )
        );
    }
}

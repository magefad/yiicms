<?php

class ContactModule extends WebModule
{
    /** @var bool */
    public $captchaRequired = true;

    public function getName()
    {
        return Yii::t('contact', 'Форма обратной связи');
    }

    public function getSettingLabels()
    {
        return array(
            'captchaRequired' => Yii::t('contact', 'Требовать ввод кода с картинки'),
        );
    }

    public function getSettingData()
    {
        return array(
            'captchaRequired' => array(
                'data'        => $this->getChoice(), //yes no
                'tag'         => 'radioButtonListInline',
                'htmlOptions' => array(
                    'hint' => Yii::t('contact', 'Используется для бобрьбы против спаммеров') . ' (captcha)',
                )
            ),
        );
    }

    public function getDescription()
    {
        return Yii::t('contact', 'Модуль для отправки сообщений с сайта');
    }

    public function getIcon()
    {
        return 'envelope';
    }

    public function init()
    {
        /** read settings from DB */
        parent::init();
        $this->setImport(
            array(
                'contact.models.*',
            )
        );
    }
}

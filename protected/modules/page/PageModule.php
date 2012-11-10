<?php

class PageModule extends WebModule
{
    /**
     * @var string DefaultPage
     */
    public $defaultPage = 'index';

    public function getSettingLabels()
    {
        return array(
            'defaultPage' => Yii::t('page', 'Главная страница (ссылка)'),
        );
    }

    public function getName()
    {
        return Yii::t('page', 'Страницы');
    }

    public function getDescription()
    {
        return Yii::t('page', 'Управление страницами сайта');
    }

    public function getIcon()
    {
        return 'font';
    }

    public function init()
    {
        $this->setImport(array('page.models.*'));
    }
}

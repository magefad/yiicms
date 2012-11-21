<?php

class PageModule extends WebModule
{
    /**
     * @var string DefaultPage
     */
    public $defaultPage = 'index';

    /**
     * @var int $page size for CActiveDataProvider pagination
     */
    public $pageSize = 50;

    public $urlRules = array(
        'page/about'           => 'contact/default',
        'page/<slug:[\w\_-]+>' => 'page/default/show',
    );

    public function getSettingLabels()
    {
        return array(
            'defaultPage' => Yii::t('page', 'Главная страница (ссылка)'),
            'pageSize'    => Yii::t('page', 'Количество результатов на одну страницу'),
        );
    }

    public function getSettingData()
    {
        return array(
            'pageSize'  => array(
                'data' => array(20 => 20, 30 => 30, 40 => 40, 50 => 50, 60 => 60, 70 => 70, 80 => 80, 90 => 90, 100 => 100),
                'tag'  => 'dropDownList',
            ),
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
        parent::init();
    }
}

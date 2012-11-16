<?php

class AdminModule extends WebModule
{
    public $siteName;
    public $siteDescription;
    public $siteKeywords;
    public $cachingDuration = 3600;
    public $uploadDir = 'uploads';
    public $email;

    public function getName()
    {
        return Yii::app()->name;
    }

    public function getSettingLabels()
    {
        return array(
            'siteName'        => Yii::t('admin', 'Название сайта'),
            'siteDescription' => Yii::t('admin', 'Описание сайта'),
            'siteKeywords'    => Yii::t('admin', 'Ключевые слова'),
            'cachingDuration' => Yii::t('admin', 'Кэширование (сек.)'),
            'uploadDir'       => Yii::t('admin', 'Каталог для файлов'),
            'email'           => Yii::t('admin', 'Email сайта'),
        );
    }

    public function getSettingData()
    {
        return array(
            'uploadDir' => array(
                'htmlOptions' => array(
                    'hint' => Yii::t('admin', 'При изменении значения требуется вручную переименовать папку на FTP'),
                )
            ),
        );
    }

    public function init()
    {
        $this->setImport(
            array(
                'admin.behaviors.*',
                'admin.models.*',
                'admin.components.*',
            )
        );
        $this->siteName = empty($this->siteName) ? Yii::app()->name : $this->siteName;
        $this->email    = isset($this->email) ? $this->email : 'mail@' . str_replace(
            'www.',
            '',
            Yii::app()->request->getServerName()
        );
        parent::init();
    }

    public function getModules()
    {
        $modules = $yiiModules = array();

        if (count(Yii::app()->modules)) {
            foreach (Yii::app()->modules as $key => $value) {
                $key = strtolower($key);
                if (!is_null($module = Yii::app()->getModule($key))) {
                    if (is_a($module, 'WebModule')) {
                        $modules[$key] = $module;
                    } else {
                        $yiiModules = $module;
                    }
                }
            }
        }
        return array('modules' => $modules, 'yiiModules' => $yiiModules);
    }
}

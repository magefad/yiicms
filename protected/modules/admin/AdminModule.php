<?php

class AdminModule extends WebModule
{
    public $siteName;
    public $siteDescription;
    public $siteKeywords;
    public $cachingDuration = 3600;
    public $uploadDir = 'uploads';
    public $email;
    /** @var string Google Analytics Account */
    public $googleAnalyticsAccount = '';

    public static function getName()
    {
        return Yii::t('admin', 'Панель управления');
    }

    public function getSettingLabels()
    {
        return array(
            'siteName'               => Yii::t('admin', 'Название сайта'),
            'cachingDuration'        => Yii::t('admin', 'Кэширование (сек.)'),
            'uploadDir'              => Yii::t('admin', 'Каталог для файлов'),
            'email'                  => Yii::t('admin', 'Email сайта'),
            'googleAnalyticsAccount' => Yii::t('admin', 'Аккаунт Google Analytics (UA-XXXXXX-X)')
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
        $this->setImport(array('admin.models.*'));
        $this->siteName = empty($this->siteName) ? Yii::app()->name : $this->siteName;
        $this->email    = isset($this->email) ? $this->email : 'mail@' . str_replace('www.', '', Yii::app()->getRequest()->getServerName());
        parent::init();
        Yii::setPathOfAlias('uploads', Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . $this->uploadDir);
    }

    public function getModules()
    {
        $modules = $yiiModules = array();

        if (count(Yii::app()->getModules())) {
            foreach (Yii::app()->getModules() as $key => $value) {
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

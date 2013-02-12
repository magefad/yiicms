<?php
/**
 * User: fad
 * Date: 05.09.12
 * Time: 11:49
 */
class NewsModule extends WebModule
{
    public $urlRules = array(
        'news/show/<slug:[\w\_-]+>' => 'news/default/show',
    );

    /** @var string 'webroot/uploads/' . $uploadDir */
    public $uploadDir = 'news';
    public $uploadAllowExt = 'jpg,jpeg,gif,bmp,png';

    /** @var int Maximum Photo width */
    public $maxWidth = 1024;
    /** @var int Maximum Photo height */
    public $maxHeight = 768;
    /** @var int Maximum Thumbnail width */
    public $thumbMaxWidth = 130;

    //widget
    public $lastNewsCount = 3;

    public static function getAdminLink()
    {
        return array('icon' => self::getIcon(), 'label' => self::getName(), 'url' => array('/news/default/admin'));
    }

    public static function getName()
    {
        return Yii::t('news', 'Новости');
    }

    public static function getDescription()
    {
        return Yii::t('news', 'Управление новостями сайта');
    }

    public static function getIcon()
    {
        return 'info-sign';
    }


    public function getSettingLabels()
    {
        return array(
            'uploadDir'      => Yii::t('news', 'Папка загрузки фото'),
            'uploadAllowExt' => Yii::t('news', 'Форматы фотографий'),
            'maxWidth'       => Yii::t('news', 'Максимальная ширина фото после загрузки'),
            'maxHeight'      => Yii::t('news', 'Максимальная высота фото после загрузки'),
            'thumbMaxWidth'  => Yii::t('news', 'Максимальная ширина миниатюры фото'),
            'lastNewsCount'  => Yii::t('news', 'Количество новостей на главной')
        );
    }

    public function getSettingData()
    {
        return array(
            'maxWidth'  => array(
                'data' => array('480' => '480', '640' => '640', '800' => '800', '1024' => '1024', '1280' => '1280'),
                'tag'  => 'dropDownList',
            ),
            'maxHeight' => array(
                'data' => array('320' => '320', '480' => '480', '600' => '600', '768' => '768', '1024' => '1024'),
                'tag'  => 'dropDownList',
            )
        );
    }

    public function getUploadPath()
    {
        return Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->uploadDir;
    }

    public function init()
    {
        parent::init();
        $this->setImport(array('news.models.*'));
    }

    /**
     * @param Controller $controller
     * @param CAction $action
     * @return bool
     */
    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            if ($action->id !== 'show' && $action->id != 'index') {
                $controller->menu = self::getAdminMenu();
            }
            return true;
        } else {
            return false;
        }
    }
}

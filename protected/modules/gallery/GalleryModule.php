<?php

class GalleryModule extends WebModule
{
    /** @var string 'webroot/uploads/' . $uploadDir */
    public $uploadDir = 'gallery';
    public $uploadAllowExt = 'jpg,jpeg,gif,bmp,png';
    /** @var int Maximum Photo width */
    public $maxWidth = 1600;
    /** @var int Maximum Photo height */
    public $maxHeight = 1200;
    /** @var int Maximum Thumbnail width */
    public $thumbMaxWidth = 130;

    public static function getAdminLink()
    {
        return array('icon' => self::getIcon(), 'label' => self::getName(), 'url' => array('/gallery/default/admin'));
    }

    public static function getName()
    {
        return Yii::t('gallery', 'Галерея');
    }

    public static function getDescription()
    {
        return Yii::t('gallery', 'Создание и управление альбомами с фотографиями');
    }

    public static function getIcon()
    {
        return 'picture';
    }

    public function getSettingLabels()
    {
        return array(
            'uploadDir'      => Yii::t('news', 'Папка галереи для фотографий'),
            'uploadAllowExt' => Yii::t('news', 'Форматы фотографий'),
            'maxWidth'       => Yii::t('news', 'Максимальная ширина фото после загрузки'),
            'maxHeight'      => Yii::t('news', 'Максимальная высота фото после загрузки'),
            'thumbMaxWidth'  => Yii::t('news', 'Максимальная ширина миниатюры фото'),
        );
    }

    public function getSettingData()
    {
        return array(
            'maxWidth'      => array(
                'data' => array(
                    '480'  => '480',
                    '640'  => '640',
                    '800'  => '800',
                    '1024' => '1024',
                    '1280' => '1280',
                    '1600' => '1600'
                ),
                'tag'  => 'dropDownList',
            ),
            'maxHeight'     => array(
                'data' => array(
                    '320'  => '320',
                    '480'  => '480',
                    '600'  => '600',
                    '768'  => '768',
                    '1024' => '1024',
                    '1200' => '1200'
                ),
                'tag'  => 'dropDownList',
            ),
            'thumbMaxWidth' => array(
                'htmlOptions' => array(
                    'hint' => "Если используется галерея Gallery с темой Folio (по умолчанию), нужно изменить значение параметра в CSS:
					<br/> .galleria-thumbnails .galleria-image {width: 130px}
					<br/>Файл: ./extensions/galleria/assets/themes/folio/galleria.folio.css
					<br/>иначе превью будут показываться размером по умолчанию 130px в ширину",
                )
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
        $this->setImport(array('gallery.models.*'));
    }

    /**
     * @param Controller $controller
     * @param CAction $action
     * @return bool
     */
    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            if ($action->id != 'list') {
                $controller->menu = $this->getAdminMenu();
            }
            return true;
        } else {
            return false;
        }
    }
}

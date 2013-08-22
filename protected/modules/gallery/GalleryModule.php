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
        return Yii::t('GalleryModule.gallery', 'Gallery');
    }

    public static function getDescription()
    {
        return Yii::t('GalleryModule.gallery', 'Create and manage albums with photos');
    }

    public static function getIcon()
    {
        return 'picture';
    }

    public function getSettingLabels()
    {
        return array(
            'uploadDir'      => Yii::t('GalleryModule.gallery', 'Directory for photos'),
            'uploadAllowExt' => Yii::t('GalleryModule.gallery', 'Supported photo formats'),
            'maxWidth'       => Yii::t('GalleryModule.gallery', 'Max photo width after upload'),
            'maxHeight'      => Yii::t('GalleryModule.gallery', 'Max photo height after upload'),
            'thumbMaxWidth'  => Yii::t('GalleryModule.gallery', 'Max thumb photo width after upload'),
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
                    'hint' => Yii::t('GalleryModule.gallery', "If you use Gallery with Folio theme (default), change CSS:
					<br/> .galleria-thumbnails .galleria-image {width: 130px}
					<br/>File: ./extensions/galleria/assets/themes/folio/galleria.folio.css
					<br/>else thumbnail will be show in 130px width"),
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

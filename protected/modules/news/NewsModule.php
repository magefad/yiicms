<?php
/**
 * User: fad
 * Date: 05.09.12
 * Time: 11:49
 */
class NewsModule extends WebModule
{
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

    public function getName()
    {
        return Yii::t('news', 'Новости');
    }

    public function getDescription()
    {
        return Yii::t('news', 'Управление новостями сайта');
    }

    public function getIcon()
    {
        return 'info-sign';
    }

    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule(
            'admin'
        )->uploadDir . DIRECTORY_SEPARATOR . $this->uploadDir;
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'news.models.*',
            )
        );
    }
}

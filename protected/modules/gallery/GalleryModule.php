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
			'maxWidth' => array(
				'data' => array('480' => '480', '640' => '640', '800' => '800', '1024' => '1024', '1280' => '1280', '1600' => '1600'),
				'tag'  => 'dropDownList',
			),
			'maxHeight' => array(
				'data' => array('320' => '320', '480' => '480', '600' => '600', '768' => '768', '1024' => '1024', '1200' => '1200'),
				'tag'  => 'dropDownList',
			)
		);
	}

	public function getName()
	{
		return Yii::t('gallery', 'Галерея');
	}

	public function getDescription()
	{
		return Yii::t('gallery', 'Создание и управление альбомами с фотографиями');
	}

	public function getIcon()
	{
		return 'picture';
	}

	public function getUploadPath()
	{
		return Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule('admin')->uploadDir . DIRECTORY_SEPARATOR . $this->uploadDir;
	}

	public function init()
	{
		$this->setImport(array(
			'gallery.models.*',
		));
	}
}

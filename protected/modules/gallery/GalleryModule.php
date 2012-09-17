<?php

class GalleryModule extends WebModule
{
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

	public function init()
	{
		$this->setImport(array(
			'gallery.models.*',
		));
	}
}

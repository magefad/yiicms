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
		return Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $this->uploadDir;
	}

	public function init()
	{
		parent::init();

		$this->setImport(array(
			'news.models.*',
		));
	}
}

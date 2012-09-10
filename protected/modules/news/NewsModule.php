<?php
/**
 * User: fad
 * Date: 05.09.12
 * Time: 11:49
 */
class NewsModule extends CWebModule
{
	/** @var string 'webroot/uploads/' . $uploadPath */
	public $uploadPath = 'news';
	public $uploadAllowExt = 'jpg,jpeg,gif,bmp,png';

	public function getUploadPath()
	{
		return Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $this->uploadPath;
	}

	public function init()
	{
		parent::init();

		$this->setImport(array(
			'news.models.*',
		));
	}
}

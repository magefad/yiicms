<?php
/**
 * User: fad
 * Date: 13.07.12
 * Time: 12:38
 */
abstract class Widget extends CWidget
{

	public $cacheTime = 3600;

	public $limit = 5;

	/*public function init()
	{
		parent::init();

		if ( !$this->cacheTime )
		{
			#$this->cacheTime = Yii::app()->
		}
	}

	public function getViewPath()
	{
		if ( !is_object(Yii::app()->theme) )
		{
			return parent::getViewPath();
		}
		$themeView = Yii::app()->themeManager->basePath . DIRECTORY_SEPARATOR . Yii::app()->theme->name . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . get_class($this);

		return file_exists($themeView) ? $themeView : parent::getViewPath($checkTheme = false);
	}*/

}

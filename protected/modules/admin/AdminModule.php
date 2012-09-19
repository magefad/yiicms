<?php

class AdminModule extends WebModule
{
	public $siteName;
	public $siteDescription;
	public $siteKeywords;
	public $theme;
	public $brandUrl;
	public $coreCacheTime = 3600;
	public $uploadDir     = 'uploads';
	public $email;

	public function getName()
	{
		return Yii::app()->name;
	}

	public function getSettingLabels()
	{
		return array(
			'siteName'        => Yii::t('admin', 'Название сайта'),
			'siteDescription' => Yii::t('admin', 'Описание сайта'),
			'siteKeywords'    => Yii::t('admin', 'Ключевые слова'),
			'theme'           => Yii::t('admin', 'Тема'),
			'coreCacheTime'   => Yii::t('admin', 'Кэширование (сек.)'),
			'uploadDir'       => Yii::t('admin', 'Каталог для файлов'),
			'email'           => Yii::t('admin', 'Email сайта'),
		);
	}
	public function getSettingData()
	{
		return array(
			'siteDescription' => array(
				#'value' => array(1  => 'val1', 2  => 'val2', 4  => 'val3', 5  => 'val4'),
				'tag'   => 'textArea'
			),
			'coreCacheTime'   => array(
				'value' => array(111 => 111, 3600 => 3600, 555 => 555, 333 => 333),
				'tag'   => 'dropDownList',
			),
			'email' => array(
				'value' => array(1 => 'yea', 2 => 'nooo'),
				'tag' => 'dropDownList'
			)
		);
	}

	public function init()
	{
		parent::init();
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));
		$this->siteName = empty($this->siteName) ? Yii::app()->name : $this->siteName;
	}

	public function getModules()
	{
		$modules = $yiiModules = array();
		if ( count(Yii::app()->modules) )
		{
			foreach ( Yii::app()->modules as $key => $value )
			{
				$key = strtolower($key);
				if ( !is_null($module = Yii::app()->getModule($key)) )
				{
					if ( is_a($module, 'WebModule') )
					{
						$modules[$key] = $module;
					}
					else
					{
						$yiiModules = $module;
					}
				}
			}
		}
		return array('modules' => $modules, 'yiiModules' => $yiiModules);
	}
}

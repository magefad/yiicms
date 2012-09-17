<?php

class MenuModule extends WebModule
{
	public function getName()
	{
		return Yii::t('menu', 'Меню');
	}

	public function getDescription()
	{
		return Yii::t('menu', 'Создание и управление ссылками меню навигации');
	}

	public function getIcon()
	{
		return 'list';
	}

	public function init()
	{
		$this->setImport(array(
			'menu.models.*',
		));
	}
}

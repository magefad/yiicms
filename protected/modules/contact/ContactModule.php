<?php

class ContactModule extends WebModule
{
	public function getName()
	{
		return Yii::t('contact', 'Форма обратной связи');
	}

	public function getDescription()
	{
		return Yii::t('contact', 'Модуль для отправки сообщений с сайта');
	}

	public function getIcon()
	{
		return 'envelope';
	}

	public function init()
	{
		$this->setImport(array(
			'contact.models.*',
		));
	}

}

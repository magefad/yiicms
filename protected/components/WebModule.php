<?php
/**
 * User: fad
 * Date: 05.09.12
 * Time: 12:00
 */
class WebModule extends CWebModule
{
	const CHECK_ERROR  = 'error';

	const CHECK_NOTICE = 'notice';

	const CHOICE_YES = 1;
	const CHOICE_NO = 0;

	public function getVersion()
	{
		return '0.0.1';
	}

	public function getName()
	{
		return Yii::t('admin', 'Нет названия');
	}

	public function getDescription()
	{
		return Yii::t('admin', 'Нет описания');
	}

	public function getAuthor()
	{
		return Yii::t('admin', 'fad');
	}

	public function getAuthorEmail()
	{
		return Yii::t('admin', 'fad@itrade-rus.ru');
	}

	public function getUrl()
	{
		return Yii::t('admin', '');
	}

	public function getIcon()
	{
		return "cog";
	}

	public function getSettingLabels()
	{
		return array();
	}

	public function getSettingData()
	{
		return array();
	}

	public function init()
	{
		$settings = Setting::model()->findAll('module_id = :module_id', array('module_id' => $this->getId()));
		if ( $settings )
		{
			$settingKeys   = array_keys($this->settingLabels);
			foreach ($settings as $model)
			{
				if ( property_exists($this, $model->key) && (in_array($model->key, $settingKeys)) )
					$this->{$model->key} = $model->value;
			}
		}
		parent::init();
	}
}

<?php
/**
 * User: fad
 * Date: 19.09.12
 * Time: 11:58
 */
class SettingController extends Controller
{
	public $defaultAction = 'update';
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array('rights');
	}

	/**
	 * @param string $slug
	 * @throws CHttpException
	 */
	public function actionUpdate($slug)
	{
		/**
		 * @var $module WebModule
		 * @var $settings Setting[]
		 */
		$module_id = $slug;
		unset($slug);
		if ( !$module = Yii::app()->getModule($module_id) )
			throw new CHttpException(404, Yii::t('admin', 'Модуль "{module}" не найден!', array('{module}' => $module_id)));

		$settings = $this->getSettingsToUpdate($module);

		if ( isset($_POST['Setting']) )
		{
			$valid = true;
			foreach ($settings as $key => $setting) //settingKey => settingData's etc..
			{
				if ( isset($_POST['Setting'][$key]) )
				{
					$settings[$key]->setAttributes($_POST['Setting'][$key]);
					$valid = $settings[$key]->validate() && $valid;
				}
			}
			if ( $valid )
			{
				Setting::model()->deleteAll('module_id = :module_id', array(':module_id' => $module_id));
				foreach ($settings as $setting)
				{
					if ( $setting->save() )
					{
						Yii::app()->user->setFlash('success', Yii::t('setting', 'Настройки сохранены!'));
					}
				}
			}
		}
		$this->render('update', array('module' => $module, 'settings' => $settings));
	}

	/**
	 * @todo move to Model
	 * @param CModule $module
	 * @return array Setting[]
	 * @throws CHttpException
	 */
	public function getSettingsToUpdate($module)
	{
		$settingLabels = $module->settingLabels;
		if ( !count($settingLabels) )
			throw new CHttpException(404, Yii::t('admin', "У модуля {name} нет настроек", array('{name}' => $module->name)));

		$settingKeys   = array_keys($settingLabels);
		$settingData   = $module->settingData;
		/** @var $settings Setting[] */
		$settings = array();
		foreach ($module as $key => $value)//settingKey and settingValue
		{
			if ( in_array($key, $settingKeys) )
			{
				if ( !(isset($settingData[$key]) && is_array($settingData[$key])) )
					$settingData[$key]['tag'] = 'textField';

				$settingData[$key]['label'] = $settingLabels[$key];
				$settings[$key] = new Setting;
				$settings[$key]->setAttributes(array(
					'module_id' => $module->id,
					'key'       => $key,
					'value'     => $value,
				));
				$settings[$key]->data = $settingData[$key];
			}
		}
		return $settings;
	}
}

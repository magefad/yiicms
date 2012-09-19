<?php

class DefaultController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array('rights');
	}

	public function actionIndex()
	{
		$this->render('index', Yii::app()->getModule('admin')->getModules());
	}

	/*public function actionSettings($module='admin')
	{
		if ( !$module = Yii::app()->getModule($module) )
			throw new CHttpException(404, Yii::t('admin', 'Страница настроек данного модуля недоступна!'));

		$formElements      = array();
		$settingLabels = $module->settingLabels;
		$settingKeys   = array_keys($settingLabels);
		//@var $settingData array values for CHtml::dropDownList
		$settingData   = $module->settingData;

		foreach ($module as $key => $value)
		{
			if ( in_array($key, $settingKeys) )
			{
				$formElements[$key]['label'] = CHtml::label(isset($settingLabels[$key]) ? $settingLabels[$key] : $key, $key, array('class' => 'control-label'));
				$tag  = isset($settingData[$key]['tag']) ? $settingData[$key]['tag'] : 'textField';
				if ( array_key_exists($key, $settingData) )
				{
					switch ( $tag )
					{
						case 'dropDownList':
							$formElements[$key]['control'] .= CHtml::$tag($key, $value, $settingData[$key]['value'], array('empty' => Yii::t('admin', '- не выбрано -')));
							break;
						case 'checkBoxList':
						case 'radioButtonList':
							$formElements[$key]['control'] .= CHtml::$tag($key, $value, $settingData[$key]['value'], array('separator' => ''));
							break;
						case 'checkBox':
						case 'radioButton':
							$formElements[$key]['control'] .= CHtml::$tag($key, $value);
							break;
						case 'textArea':
							$formElements[$key]['control'] .= CHtml::$tag($key, $value);
							break;
					}
				}
				else //textField
				{
					$formElements[$key]['control'] .= CHtml::$tag($key, $value);
				}
			}
		}

		$this->render('settings', array(
			'module'        => $module,
			'elements'      => $formElements,
			'settingLabels' => $settingLabels,
		));
	}*/
}
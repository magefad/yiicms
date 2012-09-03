<?php
/**
 * User: fad
 * Date: 13.07.12
 * Time: 13:06
 */
abstract class WebModule extends CWebModule
{
	const CHECK_ERROR  = 'error';

	const CHECK_NOTICE = 'notice';

	const CHOICE_YES = 1;
	const CHOICE_NO = 0;
	/**
	 *  @var int порядок следования модуля в меню панели управления (сортировка)
	 */
	public $adminMenuOrder = 0;
	/**
	 *  @var int
	 */
	public $coreCacheTime = 3600;
	/**
	 *  @var array правила маршрутизации модуля (импортируются при старте модуля)
	 */
	public $urlRules = null;

	public function getNavigation()
	{
		return false;
	}

	public function getChoice()
	{
		return array(
			self::CHOICE_YES => Yii::t('WebModule', 'да'),
			self::CHOICE_NO => Yii::t('WebModule', 'нет')
		);
	}

	public function init()
	{
		if (is_object(Yii::app()->theme))
			$this->layout = 'webroot.themes.' . Yii::app()->theme->name . '.views.layouts.main';

		// инициализация модуля
		/*$settings = Settings::model()->cache($this->coreCacheTime)->findAll('module_id = :module_id', array('module_id' => $this->getId()));

		if($settings)
		{
			$editableParams = $this->getEditableParams();

			//@TODO обход не settings а editableParams как вариант =)
			foreach ($settings as $model)
			{
				if (property_exists($this, $model->param_name) && (in_array($model->param_name, $editableParams) || array_key_exists($model->param_name, $editableParams)))
					$this->{$model->param_name} = $model->param_value;
			}
		}*/

		parent::init();
	}
}

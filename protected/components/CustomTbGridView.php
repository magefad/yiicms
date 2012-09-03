<?php
/**
 * User: fad
 * Date: 18.07.12
 * Time: 11:55
 */
Yii::import('bootstrap.widgets.TbGridView');
class CustomTbGridView extends TbGridView
{
	public $modelName;

	public $activeStatus = 1;

	public $inActiveStatus = 0;

	public $statusField = 'status';

	public $showStatusText = false;

	public $sortField = 'sort';

	public  function init()
	{
		parent::init();
		$this->modelName = $this->dataProvider->modelClass;
	}

	public function returnStatusHtml($data, $active = 1, $onclick = 1, $ignore = 0)
	{
		$statusField = $this->statusField;

		$status = $data->$statusField == $active ? $this->inActiveStatus : $this->activeStatus;

		$url = Yii::app()->controller->createUrl("activate", array(
			'model' => $this->modelName,
			'id' => $data->id,
			'status' => $status,
			'statusField' => $this->statusField
		));

		$img = CHtml::image(
			Yii::app()->request->baseUrl . '/web/images/' . ($data->$statusField == $active ? '' : 'in') . 'active.png',
			Yii::t('global', $data->$statusField ? Yii::t('global','Деактивировать') : Yii::t('global','Активировать')),
			array('title' => Yii::t('global', $data->$statusField ? Yii::t('global','Деактивировать') : Yii::t('global','Активировать')))
		);
		$options = array();
		if ($onclick) {
			$options = array(
				'onclick' => 'ajaxSetStatus(this, "' . $this->id . '"); return false;',
			);
		}
		$text = ($this->showStatusText && method_exists($data,'getStatus')) ? $data->getStatus() : '';

		return '<div align="center">' . CHtml::link($img, $url, $options) . $text .'</div>';
	}

	/**
	 * Генерирует HTML-код для BootStrap-иконки переключателя активности в зависимости от текущего состояния модели
	 *
	 * По-умолчанию значения состояний
	 * 0 - Черновик ( деактивировано )
	 * 1 - Опубликовано ( активировано )
	 * 2 - На модерации
	 *
	 * @param $data экземпляр модели, для которой нужно вывести переключатель
	 * @param int $active номер статуса, считаемый активным
	 * @param array $icons массив имен иконок по статусам
	 * @return string HTML-код для BootStrap-иконки переключателя
	 *
	 */
	public function returnBootstrapStatusHtml($data, $active = 1, $icons = array('eye-close','ok-sign','time'))
	{
		$statusField = $this->statusField;

		$status = $data->$statusField == $active ? $this->inActiveStatus : $this->activeStatus;

		$url = Yii::app()->controller->createUrl("activate", array(
			'model' => $this->modelName,
			'id' => $data->id,
			'status' => $status,
			'statusField' => $this->statusField
		));

		$options = array(
			'onclick' => 'ajaxSetStatus(this, "' . $this->id . '"); return false;',
		);

		$text = method_exists($data,'getStatus') ? $data->getStatus() : '';
		$text .= ". ".Yii::t('global', ($data->$statusField && $data->$statusField != 2) ? Yii::t('global', 'В черновик?') : Yii::t('global', 'Опубликовать?'));
		$icon = '<i rel="tooltip" class="mytip icon icon-'.(isset($icons[$data->$statusField]) ? $icons[$data->$statusField] : 'question-sign')."\" title='".$text."'></i>";
		return CHtml::link($icon, $url, $options);
	}

	/**
	 * Sort buttons (up-down)
	 * @todo Убрать кнопку вниз у последнего элемента
	 * @param $data
	 * @return string
	 */
	public function getUpDownButtons($data)
	{
		$downUrlImage = CHtml::image(Yii::app()->assetManager->publish(
			Yii::getPathOfAlias('zii.widgets.assets.gridview').'/down.gif'
		),Yii::t('global','Опустить ниже'),array('title' => Yii::t('global','Опустить ниже'), 'class' => 'mytip'));

		$upUrlImage = CHtml::image(Yii::app()->assetManager->publish(
			Yii::getPathOfAlias('zii.widgets.assets.gridview').'/up.gif'
		),Yii::t('global','Поднять выше'),array('title'=> Yii::t('global','Поднять выше'), 'class' => 'mytip'));

		$urlUp = Yii::app()->controller->createUrl("sort", array(
			'model' => $this->modelName,
			'id'    => $data->id,
			'sortField' => $this->sortField,
			'direction' => 'up'
		));

		$urlDown = Yii::app()->controller->createUrl("sort", array(
			'model' => $this->modelName,
			'id'    => $data->id,
			'sortField' => $this->sortField,
			'direction' => 'down'
		));

		$options = array(
			'onclick' => 'ajaxSetSort(this, "' . $this->id . '"); return false;',
		);

		$return = ( $data->{$this->sortField} != 1 ) ? CHtml::link($upUrlImage,$urlUp,$options) : '&nbsp;';
		return $return.' '.$data->{$this->sortField}.' '.CHtml::link($downUrlImage,$urlDown,$options);
	}

}

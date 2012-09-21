<?php
/**
 * @var $this Controller
 * @var $model Gallery
 */
$this->breadcrumbs = array(
	'Альбомы' => array('index'),
	$model->name,
);

$this->menu = array(
	array('label' => Yii::t('gallery', 'Галерея')),
	array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление'), 'url' => array('/gallery/default/admin')),
	array('icon' => 'file', 'label' => Yii::t('page', 'Добавить'), 'url' => array('create')),
	array(
		'icon'        => 'remove',
		'label'       => Yii::t('gallery', 'Удалить'),
		'url'         => '#',
		'linkOptions' => array(
			'submit'  => array('delete', 'id' => $model->id), 'confirm' => Yii::t('gallery', 'Уверены?')
		)
	),
);
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'       => $model,
	'attributes' => array(
		'id',
		'name',
		'description',
		'keywords',
		'slug',
		'status',
		'sort',
	),
));

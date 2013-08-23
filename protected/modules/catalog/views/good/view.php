<?php

/**
 * @var $this Controller
 * @var $model Good
 */
$this->breadcrumbs = array(
	Yii::t('CatalogModule.catalog', 'Goods') => array('admin'),
	$model->name,
);

$this->menu = array(
    array('label' => Yii::t('CatalogModule.catalog', 'Goods')),
    array('icon'  => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('CatalogModule.catalog', 'Create'), 'url' => array('create')),
    array('icon'  => 'pencil', 'label' => Yii::t('zii', 'Update'), 'url' => array('update', 'id' => $model->id)),
	array('icon'  => 'remove', 'label' => Yii::t('zii', 'Delete'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?'))),
);
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'       => $model,
	'attributes' => array(
		'id',
		'page_id',
		'name',
		'title',
		'keywords',
		'description',
		'slug',
		'status',
		'create_user_id',
		'update_user_id',
		'create_time',
		'update_time',
	),
));

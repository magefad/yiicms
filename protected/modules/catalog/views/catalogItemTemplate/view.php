<?php

/**
 * @var $this Controller
 * @var $model CatalogItemTemplate
 */
$this->breadcrumbs = array(
	Yii::t('CatalogModule.catalog', 'Item Templates') => array('admin'),
	$model->name,
);

$this->menu = array(
    array('label' => Yii::t('CatalogModule.catalog', 'Item Templates')),
    array('icon'  => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('CatalogModule.catalog', 'Create'), 'url' => array('create')),
    array('icon'  => 'pencil', 'label' => Yii::t('zii', 'Update'), 'url' => array('update', 'id'=>$model->key)),
	array('icon'  => 'remove', 'label' => Yii::t('zii', 'Delete'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->key), 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?'))),
);
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'       => $model,
	'attributes' => array(
		'key',
		'name',
		'input_type',
	),
));

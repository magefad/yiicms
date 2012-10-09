<?php

/**
 * @var $this Controller
 * @var $model Comment
 */
$this->breadcrumbs = array(
	Yii::t('comment', 'Comments') => array('admin'),
	$model->id,
);

$this->menu = array(
    array('label' => Yii::t('comment', 'Comments')),
    array('icon'  => 'list-alt', 'label' => Yii::t('comment', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('comment', 'Create'), 'url' => array('create')),
    array('icon'  => 'pencil', 'label' => Yii::t('comment', 'Update'), 'url' => array('update', 'id'=>$model->id)),
	array('icon'  => 'remove', 'label' => Yii::t('comment', 'Delete'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('comment', 'Are you sure you want to delete this item?'))),
);
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'       => $model,
	'attributes' => array(
		'id',
		'create_user_id',
		'model',
		'model_id',
		'create_time',
		'update_time',
		'text',
		'status',
		'ip',
	),
));

<?php

/**
 * @var $this Controller
 * @var $model Comment
 */
$this->breadcrumbs = array(
	Yii::t('CommentModule.comment', 'Comments') => array('admin'),
	$model->id,
);

$this->menu = array(
    array('label' => Yii::t('CommentModule.comment', 'Comments')),
    array('icon'  => 'list-alt', 'label' => Yii::t('CommentModule.comment', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('CommentModule.comment', 'Create'), 'url' => array('create')),
    array('icon'  => 'pencil', 'label' => Yii::t('CommentModule.comment', 'Update'), 'url' => array('update', 'id' => $model->id)),
	array('icon'  => 'remove', 'label' => Yii::t('CommentModule.comment', 'Delete'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('CommentModule.comment', 'Are you sure you want to delete this item?'))),
);
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'       => $model,
	'attributes' => array(
		'id',
		'model',
		'model_id',
		'text',
		'status',
		'ip',
        'create_user_id',
        'update_user_id',
        'create_time',
        'update_time',
	),
));

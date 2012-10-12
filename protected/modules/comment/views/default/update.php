<?php

/**
 * @var $this Controller
 * @var $model Comment
 */
$this->breadcrumbs = array(
	Yii::t('CommentModule.comment', 'Comments') => array('admin'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('CommentModule.comment', 'Update'),
);

$this->menu = array(
    array('label' => Yii::t('CommentModule.comment', 'Comments')),
    array('icon'  => 'list-alt', 'label' => Yii::t('CommentModule.comment', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('CommentModule.comment', 'Create'), 'url' => array('create')),
    array('icon'  => 'eye-open', 'label' => Yii::t('CommentModule.comment', 'View'), 'url' => array('view', 'id' => $model->id)),
);
echo $this->renderPartial('_form', array('model' => $model));
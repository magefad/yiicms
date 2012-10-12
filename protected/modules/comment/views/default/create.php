<?php

/**
 * @var $this Controller
 * @var $model Comment
 */
$this->breadcrumbs = array(
	Yii::t('CommentModule.comment', 'Comments') => array('admin'),
	Yii::t('CommentModule.comment', 'Create'),
);

$this->menu = array(
    array('label' => Yii::t('CommentModule.comment', 'Comments')),
    array('icon'  => 'list-alt', 'label' => Yii::t('CommentModule.comment', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('CommentModule.comment', 'Create'), 'url' => array('create')),
);
echo $this->renderPartial('_form', array('model' => $model));

<?php

/**
 * @var $this Controller
 * @var $model Comment
 */
$this->breadcrumbs = array(
	Yii::t('comment', 'Comments') => array('admin'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('comment', 'Update'),
);

$this->menu = array(
    array('label' => Yii::t('comment', 'Comments')),
    array('icon'  => 'list-alt', 'label' => Yii::t('comment', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('comment', 'Create'), 'url' => array('create')),
    array('icon'  => 'eye-open', 'label' => Yii::t('comment', 'View'), 'url' => array('view', 'id' => $model->id)),
);
echo $this->renderPartial('_form', array('model' => $model));
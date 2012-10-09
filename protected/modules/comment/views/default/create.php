<?php

/**
 * @var $this Controller
 * @var $model Comment
 */
$this->breadcrumbs = array(
	Yii::t('comment', 'Comments') => array('admin'),
	Yii::t('comment', 'Create'),
);

$this->menu = array(
    array('label' => Yii::t('comment', 'Comments')),
    array('icon'  => 'list-alt', 'label' => Yii::t('comment', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('comment', 'Create'), 'url' => array('create')),
);
echo $this->renderPartial('_form', array('model' => $model));

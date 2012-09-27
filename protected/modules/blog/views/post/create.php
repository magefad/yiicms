<?php

/**
 * @var $this Controller
 * @var $model Post
 */
$this->breadcrumbs = array(
    Yii::t('blog', 'Posts') => array('admin'),
    Yii::t('blog', 'Create'),
);

$this->menu = array(
    array('label' => Yii::t('blog', 'Posts')),
    array('icon'  => 'list-alt', 'label' => Yii::t('blog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('blog', 'Create'), 'url' => array('create')),
);
echo $this->renderPartial('_form', array('model' => $model));

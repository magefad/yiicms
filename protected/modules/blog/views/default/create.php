<?php

/**
 * @var $this Controller
 * @var $model Blog
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('admin'),
    Yii::t('BlogModule.blog', 'Create'),
);

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Blogs')),
    array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('BlogModule.blog', 'Create'), 'url' => array('/blog/default/create')),
);
echo $this->renderPartial('_form', array('model' => $model));

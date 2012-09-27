<?php

/**
 * @var $this Controller
 * @var $model Blog
 */
$this->breadcrumbs = array(
    Yii::t('blog', 'Blogs') => array('admin'),
    Yii::t('blog', 'Create'),
);

$this->menu = array(
    array('label' => Yii::t('blog', 'Blogs')),
    array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Manage'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('blog', 'Create'), 'url' => array('/blog/default/create')),
);
echo $this->renderPartial('_form', array('model' => $model));

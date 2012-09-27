<?php

/**
 * @var $this Controller
 * @var $model UserBlog
 */
$this->breadcrumbs = array(
    Yii::t('blog', 'Members') => array('admin'),
    $model->id                => array('view', 'id' => $model->id),
    Yii::t('blog', 'Update'),
);

$this->menu = array(
    array('label' => Yii::t('blog', 'Members')),
    array('icon'  => 'list-alt', 'label' => Yii::t('blog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('blog', 'Create'), 'url' => array('create')),
    array('icon'  => 'eye-open', 'label' => Yii::t('blog', 'View'), 'url' => array('view', 'id' => $model->id)),
);
echo $this->renderPartial('_form', array('model' => $model));

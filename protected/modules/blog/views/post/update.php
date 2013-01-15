<?php

/**
 * @var $this Controller
 * @var $model Post
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Posts') => array('admin'),
    $model->title           => array('view', 'id' => $model->id),
    Yii::t('BlogModule.blog', 'Update'),
);

echo $this->renderPartial('_form', array('model' => $model));

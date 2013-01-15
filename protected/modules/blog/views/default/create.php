<?php

/**
 * @var $this Controller
 * @var $model Blog
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('admin'),
    Yii::t('BlogModule.blog', 'Create'),
);

echo $this->renderPartial('_form', array('model' => $model));

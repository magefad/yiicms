<?php
/**
 * @var $this Controller
 * @var $model Post
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Posts') => array('admin'),
    Yii::t('BlogModule.blog', 'Create'),
);

echo $this->renderPartial('_form', array('model' => $model));

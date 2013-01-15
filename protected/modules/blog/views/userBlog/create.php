<?php
/**
 * @var $this Controller
 * @var $model UserBlog
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Members') => array('admin'),
    Yii::t('BlogModule.blog', 'Create'),
);

echo $this->renderPartial('_form', array('model' => $model));

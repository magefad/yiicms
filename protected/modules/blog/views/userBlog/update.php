<?php
/**
 * @var $this Controller
 * @var $model UserBlog
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Members') => array('admin'),
    $model->id                => array('view', 'id' => $model->id),
    Yii::t('BlogModule.blog', 'Update'),
);

echo $this->renderPartial('_form', array('model' => $model));

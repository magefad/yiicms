<?php
/**
 * @var $this Controller
 * @var $model News
 */
$this->breadcrumbs = array(
    Yii::t('news', 'Новости') => array('admin'),
    Yii::t('news', 'Добавление'),
);
$this->renderPartial('_form', array('model' => $model));

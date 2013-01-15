<?php
/**
 * @var $this Controller
 * @var $model Gallery
 */
$this->breadcrumbs = array(
    Yii::t('gallery', 'Изменение') => array('admin'),
    $model->title                  => array('view', 'id' => $model->id),
    Yii::t('gallery', 'Изменение'),
);
$this->renderPartial('_form', array('model' => $model));
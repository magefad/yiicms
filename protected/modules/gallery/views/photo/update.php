<?php
/**
 * @var $model Gallery
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('gallery', 'Изменение') => array('admin'),
    $model->name                   => array('view', 'id' => $model->id),
    Yii::t('gallery', 'Изменение'),
);
echo $this->renderPartial('_form', array('model' => $model));

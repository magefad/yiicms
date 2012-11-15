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

$this->menu = array(
    array('label' => Yii::t('page', 'Галерея')),
    array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление'), 'url' => array('/gallery/default/admin')),
    array('icon' => 'file', 'label' => Yii::t('page', 'Добавить'), 'url' => array('create')),
);

$this->renderPartial('_form', array('model' => $model));
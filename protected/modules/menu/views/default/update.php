<?php
/**
 * @var $this Controller
 * @var $model Menu
 */
$this->breadcrumbs = array(
    Yii::t('menu', 'Изменение') => array('admin'),
    $model->name                => array('view', 'id' => $model->id),
    Yii::t('menu', 'Изменение'),
);

$this->menu = array(
    array('label' => Yii::t('menu', 'Меню')),
    array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('create')),
    array(
        'icon'       => 'pencil white',
        'encodeLabel' => false,
        'label'      => Yii::t('page', 'Изменение'),
        'url'        => array('/menu/default/update', 'id' => $model->id)
    ),
    array('label' => Yii::t('menu', 'Пункты меню')),
    array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление'), 'url' => array('item/admin')),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('item/create')),
);
echo $this->renderPartial('_form', array('model' => $model)); ?>

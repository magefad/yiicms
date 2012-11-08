<?php
/**
 * @var $this Controller
 * @var $model Menu|NestedSetBehavior
 */
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню')        => array('default/admin'),
    Yii::t('menu', 'Изменение ' . $model->title),
);
$this->menu        = array(
    array('label' => Yii::t('menu', 'Меню')),
    array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить меню'), 'url' => array('create', 'root' => 1)),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить пункт'), 'url' => array('create')),
    array(
        'icon'        => 'pencil white',
        'encodeLabel' => false,
        'label'       => Yii::t('page', 'Изменение'),
        'url'         => array('/menu/default/update', 'id' => $model->id)
    ),
);
echo $this->renderPartial('_form', array('model' => $model, 'root' => $model->isRoot()));

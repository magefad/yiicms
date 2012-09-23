<?php
/**
 * @var $this Controller
 * @var $dataProvider CDataProvider
 */
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню')        => array('default/admin'),
    Yii::t('menu', 'Пункты меню') => array('admin'),
    Yii::t('menu', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('menu', 'Меню')),
    array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('default/admin')),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('default/create')),
    array('label' => Yii::t('menu', 'Пункты меню')),
    array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление'), 'url' => array('/menu/item/admin')),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('item/create')),
);
$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider'    => $dataProvider,
        'itemView'        => '_view',
    )
);

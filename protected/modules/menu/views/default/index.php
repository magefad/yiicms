<?php
/**
 * @var $this Controller
 * @var $dataProvider CDataProvider
 */
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню'),
);

$this->menu = array(
    array('label' => Yii::t('menu', 'Меню')),
    array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('create')),
    array('label' => Yii::t('menu', 'Пункты меню')),
    array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление'), 'url' => array('item/admin')),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('item/create')),
);
$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    )
);

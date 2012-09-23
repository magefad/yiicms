<?php
/**
 * @var $dataProvider CDataProvider
 * @var $this CController
 */
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('admin'),
    Yii::t('user', 'Управление'),
);

$this->menu = array(
    array('icon' => 'user', 'label' => Yii::t('user', 'Пользователи')),
    array('icon' => 'list-alt white', 'label' => Yii::t('user', 'Управление'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('user', 'Добавить'), 'url' => array('create')),
);

$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    )
);

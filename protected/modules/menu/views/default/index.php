<?php
/**
 * @var $this Controller
 * @var $dataProvider CDataProvider
 */
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню')        => array('default/admin'),
    Yii::t('menu', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('menu', 'Меню')),
    array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('default/admin')),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить меню'), 'url' => array('create', 'root' => 1)),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить пункт'), 'url' => array('create')),
);
$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider'    => $dataProvider,
        'itemView'        => '_view',
    )
);

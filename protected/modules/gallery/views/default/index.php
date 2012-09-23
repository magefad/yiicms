<?php
/**
 * @var $this Controller
 */
$this->breadcrumbs = array(
    'Альбомы',
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление'), 'url' => array('/gallery/default/admin')),
    array('icon' => 'file', 'label' => Yii::t('page', 'Добавить'), 'url' => array('create')),
);
$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    )
);

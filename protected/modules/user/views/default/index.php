<?php
/**
 * @var $dataProvider CDataProvider
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('admin'),
    Yii::t('user', 'Управление'),
);

$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    )
);

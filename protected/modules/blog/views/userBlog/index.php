<?php
/** @var $this Controller */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Members') => array('admin'),
);

$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    )
);

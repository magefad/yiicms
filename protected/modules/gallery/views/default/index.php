<?php
/**
 * @var $this Controller
 */
$this->breadcrumbs = array(Yii::t('gallery', 'Альбомы'));
$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    )
);

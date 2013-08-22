<?php
/**
 * @var $this Controller
 * @var $dataProvider CDataProvider
 */
$this->pageTitle   = Yii::t('PageModule.page', 'List Pages');
$this->breadcrumbs = array(Yii::t('PageModule.page', 'Pages') => array('admin'));

$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    )
);

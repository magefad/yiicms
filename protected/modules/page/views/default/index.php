<?php
/** @var $dataProvider CDataProvider */

$this->pageTitle   = Yii::t('page', 'Добавление страницы');
$this->breadcrumbs = array(
	Yii::t('page', 'Страницы') => array('admin'),
);

$this->menu = array(
	array('label' => Yii::t('page', 'Страницы')),
	array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление'), 'url' => array('admin')),
	array('icon' => 'file white', 'label' => Yii::t('page', 'Добавление'), 'url' => array('create')),
);
$this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider' => $dataProvider,
	'itemView'     => '_view',
)); ?>

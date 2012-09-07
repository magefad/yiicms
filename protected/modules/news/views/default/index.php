<?php
$this->breadcrumbs = array(
	Yii::t('news', 'Новости') => array('admin'),
);

$this->menu = array(
	array('label' => Yii::t('news', 'Новости')),
	array('icon' => 'list-alt', 'label' => Yii::t('news', 'Управление'), 'url' => array('admin')),
	array('icon' => 'th-list white', 'label' => Yii::t('news', 'Показать анонсами'), 'url' => array('/news/default/index')),
	array('icon' => 'file', 'label' => Yii::t('news', 'Создать'), 'url' => array('create')),
);

/** @var $dataProvider CDataProvider */
$this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider' => $dataProvider,
	'itemView'     => '_view',
)); ?>

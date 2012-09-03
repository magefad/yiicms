<?php
$this->breadcrumbs = array(
	Yii::t('news', 'Новости') => array('news/admin'),
);

$this->menu = array(
	array('label' => Yii::t('news', 'Новости')),
	array('icon' => 'list-alt','label' => Yii::t('news', 'Управление'), 	'url' =>array('news/admin')),
	array('icon' => 'th-list white', 'label' => Yii::t('news', 'Показать анонсами'),	'url' => array('/news/index')),
	array('icon' => 'file', 'label' => Yii::t('news', 'Создать'),	'url' => array('news/create')),
);

$this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider'	=> $dataProvider,
	'itemView' 	=> '_view',
)); ?>

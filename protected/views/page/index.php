<?php
$this->pageTitle = Yii::t('page', 'Добавление страницы');
$this->breadcrumbs = array(
	Yii::t('page', 'Страницы') => array('admin'),
	Yii::t('page', 'Создать'),
);

$this->menu = array(
	array('label' => Yii::t('page', 'Страницы')),
	array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление'), 'url' => array('/page/admin')),
	array('icon' => 'file white', 'label' => Yii::t('page', 'Добавление'), 'url' => array('/page/create')),
);
$this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

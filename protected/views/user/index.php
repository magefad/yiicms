<?php
$this->breadcrumbs = array(
	Yii::t('user', 'Пользователи') => array('/user/admin'),
	Yii::t('user', 'Управление'),
);

$this->menu = array(
	array('icon' => 'user', 'label' => Yii::t('user', 'Пользователи')),
	array('icon' => 'list-alt white', 'label' => Yii::t('user', 'Управление'), 'url' => array('/user/admin/')),
	array('icon' => 'file', 'label' => Yii::t('user', 'Добавить'), 'url' => array('/user/create')),
);

$this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

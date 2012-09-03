<?php
$this->breadcrumbs = array(
	Yii::t('news', 'Новости') => array('news/admin'),
	Yii::t('news', 'Добавление'),
);

$this->menu = array(
	array('label' => Yii::t('news', 'Новости')),
	array('icon' => 'list-alt','label' => Yii::t('news', 'Управление'), 	'url' =>array('news/admin')),
	array('icon' => 'th-list', 'label' => Yii::t('news', 'Показать анонсами'),	'url' => array('/news/index')),
	array('icon' => 'file white', 'label' => Yii::t('news', 'Создать'),	'url' => array('news/create')),
);

$this->renderPartial('_form', array('model' => $model)); ?>
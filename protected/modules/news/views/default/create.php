<?php
/** @var $model News */
$this->breadcrumbs = array(
	Yii::t('news', 'Новости') => array('admin'),
	Yii::t('news', 'Добавление'),
);

$this->menu = array(
	array('label' => Yii::t('news', 'Новости')),
	array('icon' => 'list-alt', 'label' => Yii::t('news', 'Управление'), 'url' => array('admin')),
	array('icon' => 'th-list', 'label' => Yii::t('news', 'Показать анонсами'), 'url' => array('index')),
	array('icon' => 'file white', 'label' => Yii::t('news', 'Добавить'), 'url' => array('/news/default/create')),
);

$this->renderPartial('_form', array('model' => $model));
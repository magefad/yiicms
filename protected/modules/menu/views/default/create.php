<?php
/**
 * @var $this Controller
 * @var $model Menu
 * @var $root bool
 */
$this->breadcrumbs = array(
	Yii::t('menu', 'Меню') => array('default/admin'),
	Yii::t('menu', 'Добавление'),
);

$this->menu = array(
	array('label' => Yii::t('menu', 'Меню')),
	array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('admin')),
	array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить меню'), 'url' => array('create', 'root' => 1)),
	array('icon' => 'file white', 'label' => Yii::t('menu', 'Добавление'), 'url' => array('/menu/default/create')),
);
echo $this->renderPartial('_form', array('model' => $model, 'root' => $root));

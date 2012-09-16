<?php
/**
 * @var $model User
 * @var $this CController
 */
$this->breadcrumbs = array(
	Yii::t('user', 'Пользователи') => array('admin'),
	Yii::t('user', 'Добавить'),
);

$this->menu = array(
	array('icon' => 'user', 'label' => Yii::t('user', 'Пользователи')),
	array('icon' => 'list-alt', 'label' => Yii::t('user', 'Управление'), 'url' => array('admin')),
	array('icon' => 'file white', 'label' => Yii::t('user', 'Добавление'), 'url' => array('/user/default/create')),
);

echo $this->renderPartial('_form', array('model' => $model));
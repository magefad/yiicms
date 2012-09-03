<?php
$this->breadcrumbs = array(
	Yii::t('user', 'Пользователи') => array('/user/admin'),
	Yii::t('user', 'Добавить'),
);

$this->menu = array(
	array('icon' => 'user', 'label' => Yii::t('user', 'Пользователи')),
	array('icon' => 'list-alt', 'label' => Yii::t('user', 'Управление'), 'url' => array('/user/admin/')),
	array('icon' => 'file white', 'label' => Yii::t('user', 'Добавить'), 'url' => array('/user/create')),
);

echo $this->renderPartial('_form', array('model' => $model));
?>
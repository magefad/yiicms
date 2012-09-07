<?php
/** @var $model User */
$this->pageTitle   = Yii::t('user', 'Изменение пользователя');
$this->breadcrumbs = array(
	Yii::t('user', 'Пользователи') => array('admin'),
	$model->username               => array('view', 'id' => $model->id),
	Yii::t('user', 'Изменение'),
);

$this->menu = array(
	array('icon' => 'user', 'label' => Yii::t('user', 'Пользователи')),
	array('icon' => 'list-alt', 'label' => Yii::t('user', 'Управление'), 'url' => array('admin')),
	array('icon' => 'file', 'label' => Yii::t('user', 'Добавить'), 'url' => array('create')),
	array(
		'icon'  => 'pencil white',
		'label' => Yii::t('user', 'Изменение'),
		'url'   => array('/user/default/update', 'id' => $model->id)
	),
	#array('label' => Yii::t('user', 'Посмотреть'), 'url' => array('view', 'id' => $model->id)),

	array(
		'icon'        => 'filter',
		'label'       => Yii::t('user', 'Роль доступа'),
		'url'         => array('/rights/assignment/user/', 'id' => $model->id),
		'linkOptions' => array('target' => '_blank')
	),
	array(
		'icon'  => 'pencil',
		'label' => Yii::t('user', 'Пароль'),
		'url'   => array('changepassword', 'id' => $model->id)
	),
);
echo $this->renderPartial('_form', array('model' => $model));
?>
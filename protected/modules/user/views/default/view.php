<?php
/** @var $model User */
$this->breadcrumbs = array(
	Yii::t('user', 'Пользователи') => array('admin'),
	Yii::t('user', 'Просмотр пользователя') . ' ' . $model->username,
);

$this->menu = array(
	array('icon' => 'user', 'label' => Yii::t('user', 'Пользователи')),
	array('icon' => 'list-alt', 'label' => Yii::t('user', 'Управление'), 'url' => array('admin')),
	array('icon' => 'file', 'label' => Yii::t('user', 'Добавить'), 'url' => array('create')),
	array('icon' => 'pencil', 'label' => 'Изменить', 'url' => array('update', 'id' => $model->id)),
	array(
		'icon'  => 'pencil',
		'label' => Yii::t('user', 'Пароль'),
		'url'   => array('changepassword', 'id' => $model->id)
	),
	array('icon' => 'filter', 'label' => Yii::t('user', 'Роль доступа'), 'url' => array('/rights/assignment/user/', 'id' => $model->id), 'linkOptions' => array('target' => '_blank')),
	array(
		'icon'        => 'remove',
		'label'       => 'Удалить',
		'url'         => '#',
		'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('user', 'Уверены?'))
	),
);

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'creation_date',
		'change_date',
		'firstname',
		'lastname',
		'username',
		'email',
		#'password',
		#'salt',
		array(
			'name'  => 'status',
			'value' => $model->getStatus(),
		),
		array(
			'name'  => 'access_level',
			'value' => $model->getAccessLevel(),
		),
		'last_visit',
		'registration_date',
		'registration_ip',
		'activation_ip',
		'avatar',
		'use_gravatar',
		'activate_key',
		array(
			'name'  => 'email_confirm',
			'value' => $model->getEmailConfirmStatus(),
		),
	),
)); ?>

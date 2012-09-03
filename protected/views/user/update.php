<?php
$this->pageTitle = Yii::t('user', 'Изменение пользователя');
$this->breadcrumbs = array(
	Yii::t('user', 'Пользователи') => array('/user/admin'),
	$model->username => array('view', 'id' => $model->id),
	Yii::t('user', 'Изменение'),
);

$this->menu = array(
	array('icon' => 'user', 'label' => Yii::t('user', 'Пользователи')),
	array('icon' => 'list-alt', 'label' => Yii::t('user', 'Управление'), 'url' => array('/user/admin/')),
	array('icon' => 'file', 'label' => Yii::t('user', 'Добавить'), 'url' => array('/user/create')),
	array('icon' => 'pencil white', 'encodeLabel'=> false, 'label' => Yii::t('user', 'Изменение')."<br /><span class='label' style='font-size: 80%;'>".mb_substr($model->username,0,32)."</span>", 'url' => array('/user/update', 'id' => $model->id)),
	#array('label' => Yii::t('user', 'Посмотреть'), 'url' => array('view', 'id' => $model->id)),

	array('icon' => 'filter', 'label' => Yii::t('user', 'Роль доступа'), 'url' => array('/rights/assignment/user/', 'id' => $model->id), 'linkOptions' => array('target' => '_blank')),
	array('icon' => 'pencil', 'label' => Yii::t('user', 'Пароль'), 'url' => array('/user/changepassword', 'id' => $model->id)),
);
echo $this->renderPartial('_form', array('model' => $model));
?>
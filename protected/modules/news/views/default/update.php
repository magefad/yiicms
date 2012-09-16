<?php
/** @var $model News */
$this->breadcrumbs = array(
	Yii::t('news', 'Изменение') => array('admin'),
	$model->title               => array('view', 'id'=> $model->id),
	Yii::t('news', 'Изменение'),
);

$this->menu = array(
	array('label' => Yii::t('news', 'Новости')),
	array('icon' => 'list-alt', 'label' => Yii::t('news', 'Управление'), 'url' => array('admin')),
	array('icon' => 'th-list', 'label' => Yii::t('news', 'Показать анонсами'), 'url' => array('index')),
	array('icon' => 'file', 'label' => Yii::t('news', 'Добавить'), 'url' => array('create')),
	array('label' => Yii::t('news', 'Смотреть'), 'url' => array('view', 'id' => $model->id)),
);

echo $this->renderPartial('_form', array('model'=> $model));
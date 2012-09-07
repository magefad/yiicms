<?php
/** @var $model Gallery */
$this->breadcrumbs = array(
	Yii::t('gallery', 'Изменение') => array('admin'),
	$model->name                   => array('view', 'id'=> $model->id),
	Yii::t('gallery', 'Изменение'),
);

$this->menu = array(
	array('label' => Yii::t('gallery', 'Список'), 'url' => array('index')),
	array('label' => Yii::t('gallery', 'Управление'), 'url' => array('admin')),
	array('label' => Yii::t('gallery', 'Создать'), 'url' => array('create')),
	array('label' => Yii::t('gallery', 'Смотреть'), 'url' => array('view', 'id' => $model->id)),
);
echo $this->renderPartial('_form', array('model'=> $model));
?>
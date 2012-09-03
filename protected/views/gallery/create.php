<?php
$this->breadcrumbs = array(
	Yii::t('gallery', 'Галерея') => array('admin'),
	Yii::t('gallery', 'Добавление'),
);

$this->menu = array(
	array('label' => Yii::t('page', 'Галерея')),
	array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление'), 'url' => array('/gallery/admin')),
);
echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
$this->breadcrumbs = array(
	Yii::t('news', 'Изменение') => array('admin'),
	$model->title => array('view', 'id'=>$model->id),
	Yii::t('news', 'Изменение'),
);

$this->menu = array(
	array('label' => Yii::t('news', 'Новости')),
	array('icon' => 'list-alt','label' => Yii::t('news', 'Управление'), 	'url' =>array('news/admin')),
	array('icon' => 'th-list', 'label' => Yii::t('news', 'Показать анонсами'),	'url' => array('/news/index')),
	array('icon' => 'file white', 'label' => Yii::t('news', 'Создать'),	'url' => array('news/create')),
	array('label' => Yii::t('news', 'Смотреть'),	'url' => array('view', 'id' => $model->id)),
);

echo $this->renderPartial('_form',array('model'=>$model));
?>
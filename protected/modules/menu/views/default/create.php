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

echo $this->renderPartial('_form', array('model' => $model, 'root' => $root));

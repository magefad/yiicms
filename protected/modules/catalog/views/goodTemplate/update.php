<?php

/**
 * @var $this Controller
 * @var $model GoodTemplate
 */
$this->breadcrumbs = array(
	Yii::t('CatalogModule.catalog', 'Good Templates') => array('admin'),
	$model->name => array('view', 'id' => $model->key),
	Yii::t('zii', 'Update'),
);

$this->menu = array(
    array('label' => Yii::t('CatalogModule.catalog', 'Good Templates')),
    array('icon'  => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('CatalogModule.catalog', 'Create'), 'url' => array('create')),
    array('icon'  => 'eye-open', 'label' => Yii::t('zii', 'View'), 'url' => array('view', 'id' => $model->key)),
);
echo $this->renderPartial('_form', array('model' => $model));

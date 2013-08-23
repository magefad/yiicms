<?php

/**
 * @var $this Controller
 * @var $model GoodTemplate
 */
$this->breadcrumbs = array(
	Yii::t('CatalogModule.catalog', 'Good Templates') => array('admin'),
	Yii::t('CatalogModule.catalog', 'Create'),
);

$this->menu = array(
    array('label' => Yii::t('CatalogModule.catalog', 'Good Templates')),
    array('icon'  => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('CatalogModule.catalog', 'Create'), 'url' => array('create')),
);
echo $this->renderPartial('_form', array('model' => $model));

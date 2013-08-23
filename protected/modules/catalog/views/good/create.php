<?php
/**
 * @var $this Controller
 * @var $good Good
 * @var $goodData GoodData
 */
$this->breadcrumbs = array(
	Yii::t('CatalogModule.catalog', 'Goods') => array('admin'),
	Yii::t('CatalogModule.catalog', 'Create'),
);

$this->menu = array(
    array('label' => Yii::t('CatalogModule.catalog', 'Goods')),
    array('icon'  => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('CatalogModule.catalog', 'Create'), 'url' => array('create')),
);
echo $this->renderPartial('_form', array('good' => $good, 'goodData' => $goodData));

<?php
/**
 * @var $this Controller
 * @var $good Good
 * @var $goodData GoodData[]
 */
$this->breadcrumbs = array(
	Yii::t('CatalogModule.catalog', 'Goods') => array('admin'),
	$good->name => array('view', 'id' => $good->id),
	Yii::t('zii', 'Update'),
);

$this->menu = array(
    array('label' => Yii::t('CatalogModule.catalog', 'Goods')),
    array('icon'  => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('CatalogModule.catalog', 'Create'), 'url' => array('create')),
    array('icon'  => 'eye-open', 'label' => Yii::t('zii', 'View'), 'url' => array('view', 'id' => $good->id)),
);
echo $this->renderPartial('_form', array('good' => $good, 'goodData' => $goodData));
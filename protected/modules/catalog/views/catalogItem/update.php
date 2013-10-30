<?php
/**
 * @var $this Controller
 * @var $catalogItem CatalogItem
 * @var $catalogItemData CatalogItemData[]
 */
$this->breadcrumbs = array(
	Yii::t('CatalogModule.catalog', 'Items') => array('admin'),
	$catalogItem->name => array('view', 'id' => $catalogItem->id),
	Yii::t('zii', 'Update'),
);

$this->menu = array(
    array('label' => Yii::t('CatalogModule.catalog', 'Items')),
    array('icon'  => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('CatalogModule.catalog', 'Create'), 'url' => array('create')),
    array('icon'  => 'eye-open', 'label' => Yii::t('zii', 'View'), 'url' => array('view', 'id' => $catalogItem->id)),
);
echo $this->renderPartial('_form', array('catalogItem' => $catalogItem, 'catalogItemData' => $catalogItemData));
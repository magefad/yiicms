<?php
$this->breadcrumbs = array(
    Yii::t('CatalogModule.catalog', 'Items') => array('admin'),
);

$this->menu = array(
    array('label' => Yii::t('CatalogModule.catalog', 'Items')),
    array('icon'  => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('CatalogModule.catalog', 'Create'), 'url' => array('create')),
);
?>

<h1><?php echo Yii::t('CatalogModule.catalog', 'Items'); ?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
)); ?>

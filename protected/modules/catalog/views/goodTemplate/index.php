<?php
$this->breadcrumbs = array(
    Yii::t('CatalogModule.catalog', 'Good Templates') => array('admin'),
);

$this->menu = array(
    array('label' => Yii::t('CatalogModule.catalog', 'Good Templates')),
    array('icon'  => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('CatalogModule.catalog', 'Create'), 'url' => array('create')),
);
?>

<h1>Good Templates</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
)); ?>

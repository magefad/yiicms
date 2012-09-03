<?php
$this->breadcrumbs = array(
	'Galleries',
);

$this->menu=array(
	array('label' => Yii::t('gallery', 'Управление'), 'url' => array('admin')),
	array('label' => Yii::t('gallery', 'Создать'),	'url' => array('create')),
);
?>

<h1>Galleries</h1>

<?php $this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider'	=> $dataProvider,
	'itemView' 	=> '_view',
)); ?>

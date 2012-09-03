<?php
$this->breadcrumbs = array(
	'Gallery Photos',
);

$this->menu=array(
	array('label' => Yii::t('galleryphoto', 'Управление'), 'url' => array('admin')),
	array('label' => Yii::t('galleryphoto', 'Создать'),	'url' => array('create')),
);
?>

<h1>Gallery Photos</h1>

<?php $this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider'	=> $dataProvider,
	'itemView' 	=> '_view',
)); ?>

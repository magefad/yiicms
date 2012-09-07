<?php
/** @var $dataProvider CDataProvider */
$this->breadcrumbs = array(
	Yii::t('gallery', 'Фотографии'),
);

$this->menu = array(
	array('label' => Yii::t('gallery', 'Управление'), 'url' => array('admin')),
	array('label' => Yii::t('gallery', 'Добавить'), 'url' => array('create')),
);
?>
<?php $this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider' => $dataProvider,
	'itemView'     => '_view',
)); ?>

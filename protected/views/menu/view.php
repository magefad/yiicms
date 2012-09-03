<?php
$this->breadcrumbs=array(
	'Menus' => array('index'),
	$model->name,
);
$this->menu = array(
	//@formatter:off
	array('label' => Yii::t('menu', 'Меню')),
	array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('menu/admin')),
	array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('menu/create')),
	array('icon' => 'trash', 'label' => Yii::t('menu', 'Удалить'),	'url'=>'#','linkOptions'=>array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('menu', 'Уверены?'))),

	array('label' => Yii::t('menu', 'Пункты меню')),
	array('icon' => 'list-alt','label' => Yii::t('menu', 'Управление'), 'url' => array('menuItem/admin')),
	array('icon' => 'file','label' => Yii::t('menu', 'Добавить'), 'url' => array('menuItem/create')),
	//@formatter:on
);
?>

<h1><?php echo Yii::t('menu', 'Просмотр');?> Menu #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'	=> $model,
	'attributes' => array(
		'id',
		'name',
		'code',
		'description',
		'status',
	),
)); ?>

<?php
$this->breadcrumbs=array(
	'Galleries' => array('index'),
	$model->name,
);

$this->menu=array(
	array('label' => Yii::t('gallery', 'Список'), 	'url' =>array('index')),
	array('label' => Yii::t('gallery', 'Создать'),	'url' =>array('create')),
	array('label' => Yii::t('gallery', 'Смотреть'),'url' => array('view', 'id' => $model->id)),
	array('label' => Yii::t('gallery', 'Удалить'),	'url'=>'#','linkOptions'=>array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('gallery', 'Уверены?'))),
	array('label' => Yii::t('gallery', 'Управление'), 'url' =>array('admin')),
);
?>

<h1><?php echo Yii::t('gallery', 'Просмотр');?> Gallery #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'	=> $model,
	'attributes' => array(
		'id',
		'name',
		'description',
		'keywords',
		'slug',
		'status',
		'sort',
	),
)); ?>

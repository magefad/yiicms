<?php
$this->breadcrumbs=array(
	'Gallery Photos' => array('index'),
	$model->name,
);

$this->menu=array(
	array('label' => Yii::t('galleryphoto', 'Список'), 	'url' =>array('index')),
	array('label' => Yii::t('galleryphoto', 'Создать'),	'url' =>array('create')),
	array('label' => Yii::t('galleryphoto', 'Смотреть'),'url' => array('view', 'id' => $model->id)),
	array('label' => Yii::t('galleryphoto', 'Удалить'),	'url'=>'#','linkOptions'=>array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('galleryphoto', 'Уверены?'))),
	array('label' => Yii::t('galleryphoto', 'Управление'), 'url' =>array('admin')),
);
?>

<h1><?php echo Yii::t('galleryphoto', 'Просмотр');?> GalleryPhoto #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'	=> $model,
	'attributes' => array(
		'id',
		'gallery_id',
		'name',
		'title',
		'description',
		'keywords',
		'rank',
		'file_name',
		'creation_date',
		'change_date',
		'user_id',
		'change_user_id',
		'alt',
		'type',
		'status',
		'sort',
	),
)); ?>

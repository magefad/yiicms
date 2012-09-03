<?php
$this->breadcrumbs = array(
	Yii::t('galleryphoto', 'Изменение') => array('admin'),
	$model->name => array('view', 'id'=>$model->id),
	Yii::t('galleryphoto', 'Изменение'),
);

$this->menu=array(
	array('label' => Yii::t('galleryphoto', 'Список'), 	'url' =>array('index')),
	array('label' => Yii::t('galleryphoto', 'Управление'), 'url' =>array('admin')),
	array('label' => Yii::t('galleryphoto', 'Создать'),	'url' =>array('create')),
	array('label' => Yii::t('galleryphoto', 'Смотреть'),	'url' => array('view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('galleryphoto', 'Изменение');?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
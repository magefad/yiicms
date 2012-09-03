<?php
$this->breadcrumbs = array(
	'Gallery Photos' => array('admin'),
	Yii::t('galleryphoto', 'Добавление'),
);

$this->menu = array(
	//array('label' => Yii::t('galleryphoto', 'Список', 'url' => array('index')),
	array('label' => Yii::t('galleryphoto', 'Управление'), 'url' => array('admin')),

);
?>

<h1><?php echo Yii::t('galleryphoto', 'Добавление');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
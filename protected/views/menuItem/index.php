<?php
$this->breadcrumbs = array(
	Yii::t('menu', 'Меню') => array('menu/admin'),
	Yii::t('menu', 'Пункты меню') => array('admin'),
	Yii::t('menu', 'Список пунктов меню'),
);

$this->menu = array(
	array('label' => Yii::t('menu', 'Меню')),
	array('label' => Yii::t('menu', 'Добавить'), 'url' => array('menu/create')),
	array('label' => Yii::t('menu', 'Список'), 'url' => array('menu/index')),
	array('label' => Yii::t('menu', 'Управление'), 'url' => array('menu/admin')),

	array('label' => Yii::t('menu', 'Элементы меню')),
	array('label' => Yii::t('menu', 'Добавить пункт'), 'url' => array('create')),
	array('label' => Yii::t('menu', 'Управление пунктами'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('menu', 'Пункты меню'); ?></h1>

<?php $this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider'	=> $dataProvider,
	'itemView' 	=> '_view',
)); ?>

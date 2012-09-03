<?php
$this->breadcrumbs = array(
	Yii::t('menu', 'Меню') => array('menu/admin'),
	Yii::t('menu', 'Пункты меню') => array('admin'),
	$model->title => array(
		'viewMenuItem',
		'id' => $model->id,
	),
	Yii::t('menu', 'Изменение'),
);
$this->menu = array(
	//@formatter:off
	array('label' => Yii::t('menu', 'Меню')),
	array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('menu/admin')),
	array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('menu/create')),

	array('label' => Yii::t('menu', 'Пункты меню')),
	array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление'), 'url' => array('menuItem/admin')),
	array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('menuItem/create')),
	array('icon' => 'pencil white', 'encodeLabel'=> false, 'label' => Yii::t('page', 'Изменение')."<br /><span class='label' style='font-size: 80%;'>".mb_substr($model->title,0,32)."</span>", 'url' => array('/menuitem/update', 'id'=> $model->id)),
	//@formatter:on
);

?>

<h1><?php echo Yii::t('menu', 'Изменение пункта меню');?> <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
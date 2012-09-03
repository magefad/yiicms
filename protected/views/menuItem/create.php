<?php
$this->breadcrumbs = array(
	Yii::t('menu', 'Меню') => array('menu/admin'),
	Yii::t('menu', 'Пункты меню') => array('admin'),
	Yii::t('menu', 'Добавление'),
);

$this->menu = array(
	//@formatter:off
	array('label' => Yii::t('menu', 'Меню')),
	array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('menu/admin')),
	array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('menu/create')),

	array('label' => Yii::t('menu', 'Пункты меню')),
	array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление'), 'url' => array('menuItem/admin')),
	array('icon' => 'file white', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('menuItem/create')),
	//@formatter:on
);
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
<?php
$this->breadcrumbs = array(
	Yii::t('menu', 'Меню'),
);

$this->menu = array(
	//@formatter:off
	array('label' => Yii::t('menu', 'Меню')),
	array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('admin')),
	array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('create')),

	array('label' => Yii::t('menu', 'Пункты меню')),
	array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление'), 'url' => array('item/admin')),
	array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('item/create')),
	//@formatter:on
);
?>
<?php
/** @var $dataProvider CDataProvider */
$this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider' => $dataProvider,
	'itemView'     => '_view',
)); ?>

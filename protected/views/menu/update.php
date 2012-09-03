<?php
$this->breadcrumbs = array(
	Yii::t('menu', 'Изменение') => array('admin'),
	$model->name => array('view', 'id'=>$model->id),
	Yii::t('menu', 'Изменение'),
);

$this->menu = array(
	//@formatter:off
	array('label' => Yii::t('menu', 'Меню')),
	array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('menu/admin')),
	array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('menu/create')),
	array('icon' => 'pencil white', 'encodeLabel'=> false, 'label' => Yii::t('page', 'Изменение')."<br /><span class='label' style='font-size: 80%;'>".mb_substr($model->name,0,32)."</span>", 'url' => array('/menu/update', 'id'=> $model->id)),

	array('label' => Yii::t('menu', 'Пункты меню')),
	array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление'), 'url' => array('menuItem/admin')),
	array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('menuItem/create')),
	//@formatter:on
);
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
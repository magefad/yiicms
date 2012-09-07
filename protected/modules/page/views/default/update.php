<?php
/** @var $model Page */
/** @var $pages array */
$this->pageTitle   = Yii::t('page', 'Редактирование страницы');
$this->breadcrumbs = array(
	Yii::t('page', 'Страницы') => array('admin'), #index
	$model->title              => array('view', 'id' => $model->id), #
	Yii::t('page', 'Изменение страницы') . ' «' . $model->title . '»',
);
$this->menu        = array(
	array('label' => Yii::t('page', 'Страницы')),
	array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление'), 'url' => array('admin')),
	array('icon' => 'file', 'label' => Yii::t('page', 'Добавить'), 'url' => array('create')),
	array(
		'icon'        => 'pencil white',
		'encodeLabel' => false,
		'label'       => Yii::t('page', 'Изменение'),
		'url'         => array('/page/default/update', 'id'=> $model->id)
	),
	array(
		'icon'        => 'eye-open',
		'label'       => Yii::t('page', 'Предпросмотр'),
		'url'         => 'javascript:',
		'linkOptions' => array('id' => 'ajaxPreview')
	),
);
echo $this->renderPartial('_form', array('model' => $model, 'pages' => $pages));
?>
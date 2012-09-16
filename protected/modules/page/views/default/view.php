<?php
/** @var $model Page */
/** @var $this Controller */
$this->pageTitle   = Yii::t('page', 'Просмотр страницы');
$this->breadcrumbs = array(
	Yii::t('page', 'Страницы') => array('admin'), #index
	$model->title,
);

$this->menu = array(
	array('label' => Yii::t('page', 'Страницы')),
	array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление'), 'url' => array('admin')),
	array('icon' => 'file', 'label' => Yii::t('page', 'Добавить'), 'url' => array('create')),
	array(
		'icon'  => 'pencil',
		'label' => Yii::t('page', 'Изменить'),
		'url'   => array('update', 'id' => $model->id)
	),
	array(
		'icon'        => 'remove',
		'label'       => Yii::t('page', 'Удалить'),
		'url'         => '#',
		'linkOptions' => array(
			'submit'  => array('delete', 'id' => $model->id),
			'confirm' => Yii::t('page', 'Подтверждаете удаление страницы ?')
		)
	),
);
echo CHtml::link(Yii::t('page', 'Просмотреть на сайте'), array(
		'show',
		'slug'    => $model->slug,
		'preview' => 1
	), array('target' => '_blank'));

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'creation_date',
		'change_date', array(
			'name' => 'user_id',
			'value' => $model->author->getFullName()
		),
		'menu_order', array(
			'name'  => 'change_user_id',
			'value' => $model->changeAuthor->getFullName()
		),
		'name',
		'title',
		'slug',
		'body',
		'keywords',
		'description',
		array(
			'name'  => 'status',
			'value' => $model->getStatus()
		),
		array(
			'name'  => 'is_protected',
			'value' => $model->getProtectedStatus()
		)
	),
));
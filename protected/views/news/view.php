<?php
$this->breadcrumbs=array(
	Yii::t('news', 'Новости') => array('news/admin'),
	$model->title,
);

$this->menu = array(
	array('label' => Yii::t('news', 'Новости')),
	array('icon' => 'list-alt','label' => Yii::t('news', 'Управление'), 	'url' =>array('news/admin')),
	array('icon' => 'th-list', 'label' => Yii::t('news', 'Показать анонсами'),	'url' => array('/news/index')),
	array('icon' => 'file', 'label' => Yii::t('news', 'Создать'),	'url' => array('news/create')),
	array('icon' => 'pencil', 'label' => Yii::t('news', 'Изменить'),'url' => array('news/update', 'id' => $model->id)),
	array('icon' => 'remove', 'label' => Yii::t('news', 'Удалить'),	'url'=>'#','linkOptions'=>array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('news', 'Уверены?'))),

);
$this->widget('bootstrap.widgets.TbTabs', array(
	'type' => 'tabs', // 'tabs' or 'pills'
    'tabs' => array(
		array(
			'label' => Yii::t('news','Анонс новости'),
			'content' =>
				'<h6><span class="label">'.$model->date.'</span> '.CHtml::link($model->title, array('/news/show', 'title' => $model->slug)).'</h6>'.
				$model->body_cut,
			'active' => true
		),
		array(
			'label' => Yii::t('news','Полная новость'),
			'content' =>
				'<h3>'.CHtml::link($model->title, array('/news/show', 'title' => $model->slug)).'</h3>'.
				$model->body.
				'<span class="label">'.$model->date.'</span> <i class="icon-user"></i>'.CHtml::link($model->author->username, array('/user/people/'.$model->author->username)).
				'<br />'
		)
	)
));
echo '<br />';
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'	=> $model,
	'attributes' => array(
		'id',
		'creation_date',
		'change_date',
		'date',
		'title',
		'slug',
		#'body_cut',
		#'body',
		'user_id',
		'status',
		'is_protected',
		'keywords',
		'description',
	),
)); ?>

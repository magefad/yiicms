<?php
/**
 * @var $this Controller
 * @var $model News
 */
$this->breadcrumbs = array(
	Yii::t('news', 'Новости') => array('admin'),
	$model->title,
);
$this->menu = array(
	array('label' => Yii::t('news', 'Новости')),
	array('icon' => 'list-alt', 'label' => Yii::t('news', 'Управление'), 'url' => array('admin')),
	array('icon' => 'th-list', 'label' => Yii::t('news', 'Показать анонсами'), 'url' => array('index')),
	array('icon' => 'file', 'label' => Yii::t('news', 'Добавить'), 'url' => array('create')),
	array('icon' => 'pencil', 'label' => Yii::t('news', 'Изменить'), 'url' => array('update', 'id' => $model->id)),
	array(
		'icon'       => 'remove',
		'label'      => Yii::t('news', 'Удалить'),
		'url'        => '#',
		'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('news', 'Уверены?'))
	),
);
$this->widget('bootstrap.widgets.TbTabs', array(
	'type' => 'tabs', // 'tabs' or 'pills'
	'tabs' => array(
		array(
			'label'   => Yii::t('news', 'Анонс новости'),
			'content' => '<h6><span class="label">' . $model->date . '</span> ' . CHtml::link($model->title, array(
				'/news/show',
				'title' => $model->slug
			)) . '</h6>' . $model->content_short,
			'active'  => true
		), array(
			'label'   => Yii::t('news', 'Полная новость'),
			'content' => '<h3>' . CHtml::link($model->title, array(
				'/news/show',
				'title' => $model->slug
			)) . '</h3>' . $model->content . '<span class="label">' . $model->date . '</span> <i class="icon-user"></i>' . CHtml::link($model->author->username, array('/user/people/' . $model->author->username)) . '<br />'
		)
	)
));
echo '<br />';
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'    => $model,
	'attributes' => array(
		'id',
		'date',
		'title',
        'keywords',
        'description',
		#'content_short',
		#'content',
        'slug',
		'status',
		array(
            'name' => 'is_protected',
            'value' => $model->statusProtected->getText()
        ),
        'create_user_id',
        'update_user_id',
        'create_time',
        'update_time',
	),
));

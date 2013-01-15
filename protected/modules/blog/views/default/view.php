<?php
/**
 * @var $this Controller
 * @var $model Blog
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('admin'),
    $model->title,
);

$this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'title',
            'description',
            'slug',
            'type',
            'status',
            'create_user_id',
            'update_user_id',
            'create_time',
            'update_time',
        ),
    )
);

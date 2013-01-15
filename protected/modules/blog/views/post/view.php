<?php
/**
 * @var $this Controller
 * @var $model Post
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Posts') => array('admin'),
    $model->title,
);

$this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'blog_id',
            'title',
            'keywords',
            'description',
            'content',
            'slug',
            'link',
            'status',
            'comment_status',
            'access_type',
            'create_user_id',
            'update_user_id',
            'publish_time',
            'create_time',
            'update_time',
        ),
    )
);

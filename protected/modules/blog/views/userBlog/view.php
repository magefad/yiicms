<?php
/**
 * @var $this Controller
 * @var $model UserBlog
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Members') => array('admin'),
    $model->id,
);

$this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'user_id',
            'blog_id',
            'role',
            'status',
            'note',
            'create_time',
            'update_time',
        ),
    )
);

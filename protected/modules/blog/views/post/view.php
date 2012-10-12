<?php

/**
 * @var $this Controller
 * @var $model Post
 */
$this->breadcrumbs = array(
    Yii::t('blog', 'Posts') => array('admin'),
    $model->title,
);

$this->menu = array(
    array('label' => Yii::t('blog', 'Posts')),
    array('icon'  => 'list-alt', 'label' => Yii::t('blog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('blog', 'Create'), 'url' => array('create')),
    array('icon'  => 'pencil', 'label' => Yii::t('blog', 'Update'), 'url' => array('update', 'id'=> $model->id)),
    array('icon'        => 'remove',
          'label'       => Yii::t('blog', 'Delete'),
          'url'         => '#',
          'linkOptions' => array('submit'  => array('delete', 'id' => $model->id),
                                 'confirm' => Yii::t('blog', 'Are you sure you want to delete this item?')
          )
    ),
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

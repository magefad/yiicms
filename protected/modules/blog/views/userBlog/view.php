<?php

/**
 * @var $this Controller
 * @var $model UserBlog
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Members') => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Members')),
    array('icon'  => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('BlogModule.blog', 'Create'), 'url' => array('create')),
    array('icon'  => 'pencil', 'label' => Yii::t('BlogModule.blog', 'Update'), 'url' => array('update', 'id'=> $model->id)),
    array('icon'        => 'remove',
          'label'       => Yii::t('BlogModule.blog', 'Delete'),
          'url'         => '#',
          'linkOptions' => array('submit'  => array('delete', 'id' => $model->id),
                                 'confirm' => Yii::t('BlogModule.blog', 'Are you sure you want to delete this item?')
          )
    ),
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

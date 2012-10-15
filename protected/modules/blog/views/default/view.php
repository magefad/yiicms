<?php
/**
 * @var $this Controller
 * @var $model Blog
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('admin'),
    $model->title,
);

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Blogs')),
    array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('BlogModule.blog', 'Create'), 'url' => array('create')),
    array('icon' => 'pencil', 'label' => Yii::t('BlogModule.blog', 'Update'), 'url' => array('update', 'id' => $model->id)),
    array('icon'  => 'eye-open',
          'label' => Yii::t('BlogModule.blog', 'View'),
          'url'   => array('/blog/default/view', 'id' => $model->id)
    ),
    array(
        'icon'        => 'remove',
        'label'       => Yii::t('BlogModule.blog', 'Delete'),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array('delete', 'id' => $model->id),
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

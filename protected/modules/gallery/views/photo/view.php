<?php
/**
 * @var $model Photo
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('gallery', 'Фотографии') => array('admin'),
    $model->name,
);

$this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'gallery_id',
            'name',
            'title',
            'description',
            'keywords',
            'file_name',
            'alt',
            'type',
            'status',
            'sort_order',
            'create_user_id',
            'update_user_id',
            'create_time',
            'update_time',
        ),
    )
);

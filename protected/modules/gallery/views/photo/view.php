<?php
/**
 * @var $model Photo
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('gallery', 'Фотографии') => array('admin'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('gallery', 'Список'), 'url' => array('index')),
    array('label' => Yii::t('gallery', 'Добавить'), 'url' => array('create')),
    array('label' => Yii::t('gallery', 'Смотреть'), 'url' => array('view', 'id' => $model->id)),
    array(
        'label'      => Yii::t('gallery', 'Удалить'),
        'url'        => '#',
        'linkOptions' => array(
            'submit'  => array('delete', 'id' => $model->id),
            'confirm' => Yii::t('gallery', 'Уверены?')
        )
    ),
    array('label' => Yii::t('gallery', 'Управление'), 'url' => array('admin')),
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
            'sort',
            'create_user_id',
            'update_user_id',
            'create_time',
            'update_time',
        ),
    )
);

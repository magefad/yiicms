<?php
/**
 * @var $this Controller
 * @var $model Gallery
 */
$this->breadcrumbs = array(
    Yii::t('GalleryModule.gallery', 'Albums') => array('index'),
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
            'keywords',
            'slug',
            'status',
            'sort_order',
        ),
    )
);

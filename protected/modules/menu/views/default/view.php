<?php
/**
 * @var $this Controller
 * @var $model Menu
 */
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню')        => array('default/admin'),
    $model->title,
);
$this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'title',
            'href',
            array(
                'name'  => 'status',
                'value' => $model->statusMain->getText(),
            ),
        ),
    )
);

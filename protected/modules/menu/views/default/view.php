<?php
/**
 * @var $this Controller
 * @var $model Menu
 */
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню')        => array('default/admin'),
    $model->title,
);
$this->menu        = array(
    array('label' => Yii::t('menu', 'Меню')),
    array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить меню'), 'url' => array('create', 'root' => 1)),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить пункт'), 'url' => array('create')),
    array(
        'icon'        => 'trash',
        'label'       => Yii::t('menu', 'Удалить'),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array('delete', 'id' => $model->id),
            'confirm' => Yii::t('menu', 'Увереный?')
        ),
    ),
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

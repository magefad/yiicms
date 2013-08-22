<?php
/**
 * @var $this Controller
 * @var $model Page
 */
$this->pageTitle   = Yii::t('PageModule.page', 'Viewing Page');
$this->breadcrumbs = array(
    Yii::t('PageModule.page', 'Pages') => array('admin'),
    $model->title,
);

$this->menu = $this->module->adminMenu;
echo CHtml::link(
    Yii::t('PageModule.page', 'See on Site'),
    array(
        'show',
        'slug'    => $model->slug,
        'preview' => 1
    ),
    array('target' => '_blank')
);

$this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'sort_order',
            'name',
            'title',
            'keywords',
            'description',
            //'content',
            'slug',
            array(
                'name'  => 'status',
                'value' => $model->statusMain->getText()
            ),
            array(
                'name'  => 'is_protected',
                'value' => $model->statusProtected->getText()
            ),
            array(
                'name'  => 'create_user_id',
                'value' => $model->author->getFullName()
            ),
            array(
                'name'  => 'update_user_id',
                'value' => $model->changeAuthor->getFullName()
            ),
            'create_time',
            'update_time',
        ),
    )
);

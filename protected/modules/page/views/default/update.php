<?php

/**
 * @var $model Page
 * @var $pages array
 * @var $this Controller
 */
$this->pageTitle   = Yii::t('page', 'Редактирование страницы');
$this->breadcrumbs = array(
    Yii::t('page', 'Страницы') => array('admin'), #index
    $model->title              => array('show', 'slug' => $model->slug), #
    Yii::t('page', 'Изменение страницы') . ' «' . $model->title . '»',
);
if (!$model->isNewRecord) {
    $viewLink = array(
        'icon'        => 'eye-open',
        'label'       => Yii::t('page', 'Открыть на сайте'),
        'url'         => array('show', 'slug' => $model->slug),
        'linkOptions' => array('target' => '_blank')
    );
}
$this->menu = array(
    array('label' => Yii::t('page', 'Страницы')),
    array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('page', 'Добавить'), 'url' => array('create')),
    array(
        'icon'        => 'pencil white',
        'encodeLabel' => false,
        'label'       => Yii::t('page', 'Изменение'),
        'url'         => array('/page/default/update', 'id' => $model->id)
    ),
    array(
        'icon'        => 'eye-open',
        'label'       => Yii::t('page', 'Предпросмотр'),
        'url'         => 'javascript:',
        'linkOptions' => array('id' => 'ajaxPreview')
    ),
    $viewLink
);
echo $this->renderPartial('_form', array('model' => $model, 'pages' => $pages));

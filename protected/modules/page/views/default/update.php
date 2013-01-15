<?php

/**
 * @var $model Page
 * @var $this Controller
 */
$this->pageTitle   = Yii::t('page', 'Редактирование страницы');
$this->breadcrumbs = array(
    Yii::t('page', 'Страницы') => array('admin'), #index
    $model->title              => array('show', 'slug' => $model->slug), #
    Yii::t('page', 'Изменение страницы'),
);

$this->menu[] = array(
    'icon'        => 'eye-open',
    'label'       => Yii::t('page', 'Предпросмотр'),
    'url'         => 'javascript:',
    'linkOptions' => array('id' => 'ajaxPreview')
);
if (!$model->isNewRecord) {
    $this->menu[] = array(
        'icon'        => 'eye-open',
        'label'       => Yii::t('page', 'Открыть на сайте'),
        'url'         => array('show', 'slug' => $model->slug),
        'linkOptions' => array('target' => '_blank')
    );
}
echo $this->renderPartial('_form', array('model' => $model));

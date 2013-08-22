<?php

/**
 * @var $model Page
 * @var $this Controller
 */
$this->pageTitle   = Yii::t('PageModule.page', 'Editing Page');
$this->breadcrumbs = array(
    Yii::t('PageModule.page', 'Pages') => array('admin'), #index
    $model->title              => array('show', 'slug' => $model->slug), #
    Yii::t('PageModule.page', 'Editing Page'),
);

$this->menu[] = array(
    'icon'        => 'eye-open',
    'label'       => Yii::t('PageModule.page', 'Preview'),
    'url'         => 'javascript:',
    'linkOptions' => array('id' => 'ajaxPreview')
);
if (!$model->isNewRecord) {
    $this->menu[] = array(
        'icon'        => 'eye-open',
        'label'       => Yii::t('PageModule.page', 'Open on Site'),
        'url'         => array('show', 'slug' => $model->slug),
        'linkOptions' => array('target' => '_blank')
    );
}
echo $this->renderPartial('_form', array('model' => $model));

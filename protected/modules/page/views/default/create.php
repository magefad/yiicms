<?php
/**
 * @var $this Controller
 * @var $model Page
 */
$this->pageTitle   = Yii::t('PageModule.page', 'Adding Page');
$this->breadcrumbs = array(
    Yii::t('PageModule.page', 'Pages') => array('admin'),
    Yii::t('PageModule.page', 'Adding'),
);

$this->menu[] = array(
    'icon'        => 'eye-open',
    'label'       => Yii::t('PageModule.page', 'Preview'),
    'url'         => 'javascript:',
    'linkOptions' => array('id' => 'ajaxPreview')
);
echo $this->renderPartial('_form', array('model' => $model));
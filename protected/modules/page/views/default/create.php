<?php
/**
 * @var $this Controller
 * @var $model Page
 */
$this->pageTitle   = Yii::t('page', 'Добавление страницы');
$this->breadcrumbs = array(
    Yii::t('page', 'Страницы') => array('admin'),
    Yii::t('page', 'Добавление'),
);

$this->menu[] = array(
    'icon'        => 'eye-open',
    'label'       => Yii::t('page', 'Предпросмотр'),
    'url'         => 'javascript:',
    'linkOptions' => array('id' => 'ajaxPreview')
);
echo $this->renderPartial('_form', array('model' => $model));
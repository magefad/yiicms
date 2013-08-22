<?php
/**
 * @var $this Controller
 * @var $model News
 */
$this->breadcrumbs = array(
    Yii::t('NewsModule.news', 'News') => array('admin'),
    Yii::t('NewsModule.news', 'Adding'),
);
$this->renderPartial('_form', array('model' => $model));

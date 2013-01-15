<?php
/**
 * @var $this Controller
 * @var $model Gallery
 */
$this->breadcrumbs = array(
    Yii::t('gallery', 'Галерея') => array('admin'),
    Yii::t('gallery', 'Добавление'),
);
echo $this->renderPartial('_form', array('model' => $model));

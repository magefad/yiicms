<?php
/**
 * @var $model Photo
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('gallery', 'Фотографии') => array('admin'),
    Yii::t('gallery', 'Добавление'),
);
echo $this->renderPartial('_form', array('model' => $model));

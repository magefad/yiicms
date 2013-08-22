<?php
/**
 * @var $this Controller
 * @var $model Gallery
 */
$this->breadcrumbs = array(
    Yii::t('GalleryModule.gallery', 'Changing') => array('admin'),
    $model->title                  => array('view', 'id' => $model->id),
    Yii::t('GalleryModule.gallery', 'Changing'),
);
$this->renderPartial('_form', array('model' => $model));
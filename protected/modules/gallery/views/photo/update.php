<?php
/**
 * @var $model Gallery
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('GalleryModule.gallery', 'Changing') => array('admin'),
    $model->name                   => array('view', 'id' => $model->id),
    Yii::t('GalleryModule.gallery', 'Changing'),
);
echo $this->renderPartial('_form', array('model' => $model));

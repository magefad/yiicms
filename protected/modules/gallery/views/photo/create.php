<?php
/**
 * @var $model Photo
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('GalleryModule.gallery', 'Photos') => array('admin'),
    Yii::t('GalleryModule.gallery', 'Adding'),
);
echo $this->renderPartial('_form', array('model' => $model));

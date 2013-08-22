<?php
/**
 * @var $this Controller
 * @var $model Gallery
 */
$this->breadcrumbs = array(
    Yii::t('GalleryModule.gallery', 'Gallery') => array('admin'),
    Yii::t('GalleryModule.gallery', 'Adding'),
);
echo $this->renderPartial('_form', array('model' => $model));

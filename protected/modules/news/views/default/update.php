<?php
/**
 * @var $this Controller
 * @var $model News
 */
$this->breadcrumbs = array(
    Yii::t('news', 'Изменение') => array('admin'),
    $model->title               => array('view', 'id' => $model->id),
    Yii::t('news', 'Изменение'),
);
echo $this->renderPartial('_form', array('model' => $model));

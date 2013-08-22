<?php
/**
 * @var $this Controller
 * @var $model News
 */
$this->breadcrumbs = array(
    Yii::t('NewsModule.news', 'Changing') => array('admin'),
    $model->title                         => array('view', 'id' => $model->id),
    Yii::t('NewsModule.news', 'Changing'),
);
echo $this->renderPartial('_form', array('model' => $model));

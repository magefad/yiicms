<?php
/**
 * @var $this Controller
 * @var $model Menu|NestedSetBehavior
 */
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню')        => array('default/admin'),
    Yii::t('menu', 'Изменение ' . $model->title),
);
echo $this->renderPartial('_form', array('model' => $model, 'root' => $model->isRoot()));

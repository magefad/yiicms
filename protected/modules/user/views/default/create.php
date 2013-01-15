<?php
/**
 * @var $model User
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('admin'),
    Yii::t('user', 'Добавить'),
);

echo $this->renderPartial('_form', array('model' => $model));

<?php
/**
 * @var $model User
 * @var $this Controller
 */
$this->pageTitle   = Yii::t('user', 'Изменение пользователя');
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('admin'),
    $model->username               => array('view', 'id' => $model->id),
    Yii::t('user', 'Изменение'),
);

$this->menu[] = array(
    'icon'        => 'filter',
    'label'       => Yii::t('user', 'Роль доступа'),
    'url'         => array('/rights/assignment/user/', 'id' => $model->id),
    'linkOptions' => array('target' => '_blank')
);
echo $this->renderPartial('_form', array('model' => $model));

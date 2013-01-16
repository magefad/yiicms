<?php
/**
 * @var $model User
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('admin'),
    Yii::t('user', 'Просмотр пользователя') . ' ' . $model->username,
);

$this->menu[] = array(
    'icon'        => 'filter',
    'label'       => Yii::t('user', 'Права доступа'),
    'url'         => array('/auth/assignment/view', 'id' => $model->id),
    'linkOptions' => array('target' => '_blank')
);

$this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'firstname',
            'lastname',
            'username',
            'email',
            array(
                'name'  => 'status',
                'value' => $model->statusMain->getText(),
            ),
            array(
                'name'  => 'access_level',
                'value' => $model->getAccessLevel(),
            ),
            'last_visit',
            'registration_date',
            'registration_ip',
            'activation_ip',
            'avatar',
            'use_gravatar',
            'activate_key',
            array(
                'name'  => 'email_confirm',
                'value' => $model->statusEmailConfirm->getText(),
            ),
            'create_time',
            'update_time',
        ),
    )
);

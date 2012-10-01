<?php
/**
 * @var $user User
 */
$this->pageTitle = Yii::t('user', 'Профиль пользователя') . CHtml::encode($user->username);
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/people/index/'),
    CHtml::encode($user->username),
);
?>
<div class="span4 well">
    <div class="row">
        <div class="span1">
            <img src="http://critterapp.pagodabox.com/img/user.jpg" alt="" class="thumbnail">
        </div>
        <div class="span3">
            <p><?php echo CHtml::encode($user->username); ?></p>
            <strong><p><?php echo CHtml::encode($user->firstname); ?></p></strong>
            <span class=" badge badge-warning">8 messages</span> <span class=" badge badge-info">15 followers</span>
        </div>
    </div>
</div>

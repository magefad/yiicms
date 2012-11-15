<?php
/**
 * @var $user User
 * @var $this Controller
 */
$this->pageTitle = Yii::t('user', 'Профиль пользователя') . ' ' . CHtml::encode($user->username);
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/people/index/'),
    CHtml::encode($user->username),
);
?>
<div class="span5 offset3 well">
    <div class="row">
        <div class="span1">
            <?php if (!empty($user->avatar)) {
            echo CHtml::image($user->avatar);
        } else if (($user->getAvatar())) {
            echo $user->getAvatar();
        } else {
            echo CHtml::image('http://www.gravatar.com/avatar/00000000000000000000000000000000');
        }
            ?>
        </div>
        <div class="span3">
            <p><?php echo $user->username; ?></p>
            <?php if (!empty($user->firstname) || !empty($user->lastname)): ?>
            <p style="font-weight:bold">
                <?php if (!empty($user->firstname)): ?>
                <?php echo CHtml::encode($user->firstname); ?>
                <?php endif; ?>
                <?php if (!empty($user->lastname)): ?>
                <?php echo CHtml::encode($user->lastname); ?>
                <?php endif; ?>
            </p>
            <?php endif; ?>
            <?php if (!is_null($user->last_visit)): ?>
            <p>
            <?php echo Yii::t('user', 'Был на сайте') . ' ' . $user->last_visit; ?>
            </p>
            <?php endif; ?>
        </div>
    </div>
</div>

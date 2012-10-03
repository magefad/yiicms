<?php
/**
 * @var $user User
 */
?>
<html>
<head>
    <title><?php echo Yii::t('user', 'Активация Email');?></title>
</head>
<body>
<p>
    <?php echo $user->username . ', ' . Yii::t('user', 'Вы успешно зарегистрировались на сайте "{site}"!',array('{site}' => CHtml::encode(Yii::app()->name))); ?>
</p>
<p>
    <?php echo Yii::t('user', 'Для подтверждения своего email адреса, пожалуйста, перейдите по'); ?>
    <?php echo CHtml::link('ссылке', Yii::app()->controller->createAbsoluteUrl('/user/account/activateEmail', array('key' => $user->activate_key))) ?>.
</p>
<p>
    <?php echo Yii::t('user', 'С уважением, администрация сайта "{site}"!', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
</p>
</body>
</html>
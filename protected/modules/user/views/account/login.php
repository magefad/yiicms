<?php
/**
 * @var $model User
 * @var $form TbActiveForm
 * @var $this CController
 */
$this->pageTitle   = Yii::app()->name . ' - ' . Yii::t('user', 'Вход');
$this->breadcrumbs = array(
    Yii::t('user', 'Вход'),
);
?>
<?php
$this->widget('bootstrap.widgets.TbAlert');
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'login-form',
        'htmlOptions'            => array('class' => 'span3 offset4 well'),
        'enableClientValidation' => true,
        #'focus'                  => array($model, 'username'),
        'clientOptions'          => array(
            'validateOnSubmit' => true,
        ),
    )
); ?>
<div class="control-group">
    <?php echo $form->textField($model, 'username', array('class' => 'span3', 'placeholder' => $model->getAttributeLabel('username'))); ?>
    <?php echo $form->error($model, 'username'); ?>
</div>
<div class="control-group">
    <?php echo $form->passwordField($model, 'password', array('class' => 'span3', 'placeholder' => $model->getAttributeLabel('password'))); ?>
    <?php echo $form->error($model, 'password'); ?>
</div>
<div class="control-group">
    <?php echo $form->checkBoxRow($model, 'rememberMe'); ?>
    <?php echo $form->error($model, 'rememberMe'); ?>
</div>
<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'type'        => 'info',
        'label'       => Yii::t('user', 'Войти'),
        'htmlOptions' => array('class' => '')
    )
); ?>
<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'type'        => 'warning',
        'url'         => array('registration'),
        'label'       => Yii::t('user', 'Регистрация'),
        'htmlOptions' => array('style' => 'float:right')
    )
); ?>
<?php $this->endWidget(); ?>
<style>.auth-service {margin-right: 0.5em;}</style>
<div class="span3 offset4 well">
    <legend>Войти с помощью:</legend>
    <?php $this->widget('application.modules.user.extensions.eauth.EAuthWidget', array('action' => 'account/login')); ?>
</div>

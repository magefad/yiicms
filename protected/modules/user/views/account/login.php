<?php
/**
 * @var $model User
 * @var $form TbActiveForm
 * @var $this Controller
 */
$this->pageTitle   = Yii::app()->name . ' - ' . Yii::t('user', 'Вход');
$this->breadcrumbs = array(Yii::t('user', 'Вход'));

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'login-form',
        'htmlOptions'            => array('class' => 'span3 offset4 well'),
        'enableClientValidation' => true,
        'focus'                  => array($model, 'username'),
        'clientOptions'          => array('validateOnSubmit' => true)
    )
); ?>
<div class="control-group row-fluid">
    <?php echo $form->textField($model, 'username', array('class' => 'span12', 'placeholder' => $model->getAttributeLabel('username'))); ?>
    <?php echo $form->error($model, 'username'); ?>
</div>
<div class="control-group row-fluid">
    <?php echo $form->passwordField($model, 'password', array('class' => 'span12', 'placeholder' => $model->getAttributeLabel('password'))); ?>
    <?php echo $form->error($model, 'password'); ?>
</div>
<div class="control-group row-fluid">
    <?php echo $form->checkBoxRow($model, 'rememberMe'); ?>
    <?php echo $form->error($model, 'rememberMe'); ?>
</div>
<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'type'        => 'info',
        'label'       => Yii::t('user', 'Войти'),
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
);
$this->endWidget();
Yii::app()->clientScript->registerCss('login-form', '.auth-service {margin-right: 0.2em;font-size: 12px}');
?>
<div class="span3 offset4 well">
    <legend><?php echo Yii::t('user', 'Войти с помощью:'); ?></legend>
    <?php $this->widget('application.modules.user.extensions.eauth.EAuthWidget', array('action' => 'account/login')); ?>
</div>

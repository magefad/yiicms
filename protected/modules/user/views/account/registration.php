<?php
/**
 * @var $model User
 * @var $form TbActiveForm
 * @var $this Controller
 */
$this->pageTitle   = Yii::app()->name . ' - ' . Yii::t('user', 'Регистрация');
$this->breadcrumbs = array(Yii::t('user', 'Регистрация'));
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'registration-form',
        'type'					 => 'vertical',
        'focus'                  => array($model, 'username'),
        'enableAjaxValidation'   => true,
        'enableClientValidation' => true,
        'clientOptions'          => array('validateOnSubmit' => true),
        'htmlOptions'            => array('class' => 'span3 offset4 well'),
    )
); ?>
    <?php echo $form->errorSummary($model); ?>
<legend>
    Регистрация
</legend>
<fieldset>
<div class="row-fluid control-group">
    <?php echo $form->textField($model, 'username', array('class' => 'span12', 'placeholder' => $model->getAttributeLabel('username'))); ?>
    <?php echo $form->error($model, 'username'); ?>
</div>
<div class="row-fluid control-group">
    <?php echo $form->textField($model, 'email', array('class' => 'span12', 'placeholder' => $model->getAttributeLabel('email'))); ?>
    <?php echo $form->error($model, 'email'); ?>
</div>
<div class="row-fluid control-group">
    <?php echo $form->passwordField($model, 'password', array('class' => 'span12', 'placeholder' => $model->getAttributeLabel('password'))); ?>
    <?php echo $form->error($model, 'password'); ?>
</div>
    <?php if (CCaptcha::checkRequirements()): ?>
    <div style="text-align: center;">
        <?php $this->widget(
        'CCaptcha',
        array(
            'clickableImage'   => true,
            'showRefreshButton'=> false,
    )); ?>
    </div>
    <div class="row-fluid control-group">
        <?php echo $form->textField($model, 'verifyCode', array('class' => 'span12', 'placeholder' => $model->getAttributeLabel('verifyCode'))); ?>
        <?php echo $form->error($model, 'verifyCode'); ?>
    </div>
    <?php endif; ?>
</fieldset>
<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'label'       => Yii::t('user', 'Создать учетную запись'),
        'htmlOptions' => array('class' => 'btn-warning btn-block')
    )
); ?>
<?php $this->endWidget(); ?>

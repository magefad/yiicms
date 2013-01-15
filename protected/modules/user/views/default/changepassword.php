<?php
/**
 * @var $model User
 * @var $form TbActiveForm
 * @var $changePasswordForm changePasswordForm
 * @var $this Controller
 */

$this->pageTitle   = Yii::t('user', 'Изменение пароля');
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('admin'),
    $model->username               => array('view', 'id' => $model->id),
    Yii::t('user', 'Изменение'),
);

?>
<div class="form">
    <?php
    $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        array(
            'id'                     => 'change-user-password-form',
            'enableClientValidation' => true,
            'clientOptions'          => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions'            => array('class' => 'form-inline well'),
        )
    );
    ?>
    <?php echo $form->errorSummary($changePasswordForm); ?>
    <div class="row-fluid control-group">
        <?php echo $form->passwordField(
        $changePasswordForm,
        'password',
        array('placeholder' => 'Введите новый пароль')
    ) ?>
        <?php echo $form->error($changePasswordForm, 'password'); ?>
    </div>
    <div class="row-fluid control-group">
        <?php echo $form->passwordField(
        $changePasswordForm,
        'cPassword',
        array('placeholder' => 'Повторите введеный пароль')
    ) ?>
        <?php echo $form->error($changePasswordForm, 'cPassword'); ?>
    </div>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Сохранить')); ?>
    <?php $this->endWidget(); ?>
</div>
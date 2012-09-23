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
<div class="form">
    <?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'login-form',
        'htmlOptions'            => array('class' => 'span4 offset4 well'),
        'enableClientValidation' => true,
        'focus'                  => array($model, 'username'),
        'clientOptions'          => array(
            'validateOnSubmit' => true,
        ),
    )
); ?>
    <legend><?php echo Yii::t('user', 'Войти')?></legend>
    <div>
        <?php echo $form->textField(
        $model,
        'username',
        array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('username'))
    ); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>
    <div>
        <?php echo $form->passwordField(
        $model,
        'password',
        array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('password'))
    ); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
    <div>
        <?php echo $form->checkBoxRow($model, 'rememberMe'); ?>
        <?php echo $form->error($model, 'rememberMe'); ?>
    </div>
    <div>
        <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType'  => 'submit',
            'type'        => 'info',
            'icon'        => 'ok white',
            'label'       => Yii::t('site', 'Войти'),
            'htmlOptions' => array('class' => 'btn-block')
        )
    ); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->

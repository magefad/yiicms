<?php
$this->pageTitle = Yii::app()->name . ' - Вход';
$this->breadcrumbs = array(
	'Вход',
);
?>
<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'login-form',
	'htmlOptions'=>array('class'=>'well'),
	'enableClientValidation' => true,
	'focus' => array($model, 'username'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	<div>
		<?php echo $form->textField($model,'username', array('placeholder' => Yii::t('user', 'Логин')) ); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>
	   <div>
		<?php echo $form->passwordField($model,'password', array('placeholder' => Yii::t('user', 'Пароль'))); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<div>

		<?php echo $form->checkBoxRow($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>
	<div>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'ok white', 'label' => Yii::t('site', 'Войти'))); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'icon' => 'remove', 'label' => Yii::t('site', 'Очистить'))); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

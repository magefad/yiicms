<?php
/**
 * @var $form TbActiveForm
 * @var $model User
 * @var $this CController
 */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'                     => 'user-form',
	'enableClientValidation' => true,
	'clientOptions'          => array(
		'validateOnSubmit' => true,
	), 'htmlOptions' => array('class' => 'well'),
)); ?>

<p class="alert alert-info"><?php echo Yii::t('user', 'Поля, отмеченные <span class="required">*</span> обязательны для заполнения')?></p>
<?php echo $form->errorSummary($model); ?>
	<div>
		<?php #echo $model->getAttributeLabel('firstname');?>
		<?php echo $form->textField($model, 'firstname', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('firstname'), 'maxlength'=>150)); ?>
		<?php echo $form->error($model, 'firstname'); ?>
	</div>
	<div>
		<?php echo $form->textField($model, 'lastname', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('lastname'), 'maxlength'=>150)); ?>
		<?php echo $form->error($model, 'lastname'); ?>
	</div>
	<div>
		<?php echo $form->textField($model, 'username', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('username'), 'maxlength'=>150)); ?>
		<span class="required">*</span>
		<?php echo $form->error($model, 'username'); ?>
	</div>
	<div>
		<?php echo $form->textField($model, 'email', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('email'), 'maxlength'=>150)); ?>
		<span class="required">*</span>
		<?php echo $form->error($model, 'email'); ?>
	</div>

	<?php if ( $model->isNewRecord ) :?>
	<div>
		<?php echo $form->passwordField($model, 'password', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('password'), 'maxlength'=>32)); ?>
		<span class="required">*</span>
		<?php echo $form->error($model, 'password'); ?>
	</div>
	<div>
		<?php echo $form->dropDownListRow($model, 'access_level', $model->getAccessLevelsList(), array('class' => 'span4')); ?>
	</div>
	<?php endif; ?>

	<div>
		<?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'span4')); ?>
	</div>
	<?php echo $form->dropDownListRow($model, 'email_confirm', $model->getEmailConfirmStatusList(), array('class' => 'span4')); ?>
<div class="form-actions_">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType' => 'submit',
	'type'       => 'primary',
	'label'      => $model->isNewRecord ? Yii::t('user', 'Создать') : Yii::t('user', 'Сохранить'),
)); ?>
</div>
<?php $this->endWidget(); ?>

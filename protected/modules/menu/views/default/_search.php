<?php
/** @var $form TbActiveForm */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action' => Yii::app()->createUrl($this->route), 'method' => 'get',
)); ?>

<?php echo $form->textFieldRow($model, 'id', array('class'=> 'span5', 'maxlength'=> 10)); ?>
<?php echo $form->textFieldRow($model, 'name', array('class'=> 'span5', 'maxlength'=> 300)); ?>
<?php echo $form->textFieldRow($model, 'code', array('class'=> 'span5', 'maxlength'=> 100)); ?>
<?php echo $form->textFieldRow($model, 'description', array('class'=> 'span5', 'maxlength'=> 300)); ?>
<?php echo $form->textFieldRow($model, 'status', array('class'=> 'span5')); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType' => 'submit',
	'type'       => 'primary',
	'label'      => Yii::t('menu', 'Искать'),
)); ?>
</div>
<?php $this->endWidget(); ?>

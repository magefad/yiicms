<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
));
echo '<p>'.Yii::t('page', 'Используйте символы');?> (<b>&lt;</b>, <b>&lt;=</b>(<?php echo Yii::t('user', 'меньше или равно)');?>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b><?php echo Yii::t('page', '(не равно) или');?> <b>=</b>) <?php echo Yii::t('page', 'в начале строки поиска').'</p>';
?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'creation_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'change_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'firstname',array('class'=>'span5','maxlength'=>150)); ?>

	<?php echo $form->textFieldRow($model,'lastname',array('class'=>'span5','maxlength'=>150)); ?>

	<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>150)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>150)); ?>

	<?php echo $form->textFieldRow($model,'salt',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'access_level',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'last_visit',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'registration_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'registration_ip',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'activation_ip',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'avatar',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'use_gravatar',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'activate_key',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'email_confirm',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

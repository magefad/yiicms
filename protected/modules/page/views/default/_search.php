<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
));
echo '<p>'.Yii::t('page', 'Используйте символы');?> (<b>&lt;</b>, <b>&lt;=</b>(<?php echo Yii::t('page', 'меньше или равно)');?>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b><?php echo Yii::t('page', '(не равно) или');?> <b>=</b>) <?php echo Yii::t('page', 'в начале строки поиска').'</p>';
?>
	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'parent_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'creation_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'change_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'change_user_id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150)); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>150)); ?>

	<?php echo $form->textFieldRow($model,'slug',array('class'=>'span5','maxlength'=>150)); ?>

	<?php echo $form->textAreaRow($model,'body',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'keywords',array('class'=>'span5','maxlength'=>150)); ?>

	<?php echo $form->textFieldRow($model,'description',array('class'=>'span5','maxlength'=>250)); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'is_protected',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'menu_order',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type' => 'primary',
			'label' => Yii::t('page', 'Поиск'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>

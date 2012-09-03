<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'galleryphoto-form',
	'enableAjaxValidation' => false,
)); ?>

<p class="alert alert-info"><?php echo Yii::t('galleryphoto', 'Поля, отмеченные <span class="required">*</span> обязательны для заполнения.')?></p>
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'gallery_id',array('class'=>'span5','maxlength'=>11)); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>300)); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>150)); ?>

	<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'keywords',array('class'=>'span5','maxlength'=>150)); ?>

	<?php echo $form->textFieldRow($model,'rank',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'file_name',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'creation_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'change_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'change_user_id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'alt',array('class'=>'span5','maxlength'=>150)); ?>

	<?php echo $form->textFieldRow($model,'type',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sort',array('class'=>'span5','maxlength'=>10)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=> 'submit',
			'type' 		=> 'primary',
			'label' 	=> $model->isNewRecord ? Yii::t('galleryphoto', 'Добавить') : Yii::t('galleryphoto', 'Сохранить'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>

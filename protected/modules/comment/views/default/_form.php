<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model Comment
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'comment-form',
        'enableAjaxValidation' => false,
    )
); ?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model,'create_user_id', array('class'=>'span5','maxlength'=>10)); ?>
<?php echo $form->textFieldRow($model,'model', array('class'=>'span5','maxlength'=>50)); ?>
<?php echo $form->textFieldRow($model,'model_id', array('class'=>'span5','maxlength'=>10)); ?>
<?php echo $form->textFieldRow($model,'create_time', array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'update_time', array('class'=>'span5')); ?>
<?php echo $form->textAreaRow($model,'text', array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
<?php echo $form->textFieldRow($model,'status', array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'ip', array('class'=>'span5','maxlength'=>20)); ?>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('comment', 'Create') : Yii::t('comment', 'Save'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>

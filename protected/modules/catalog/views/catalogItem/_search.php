<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model CatalogItem
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )
); ?>

<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'page_id',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>50)); ?>
<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>75)); ?>
<?php echo $form->textFieldRow($model,'keywords',array('class'=>'span5','maxlength'=>200)); ?>
<?php echo $form->textFieldRow($model,'description',array('class'=>'span5','maxlength'=>200)); ?>
<?php echo $form->textFieldRow($model,'slug',array('class'=>'span5','maxlength'=>75)); ?>
<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'create_user_id',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'update_user_id',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); ?>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('CatalogModule.catalog', 'Search'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>


<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model GoodTemplate
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'good-template-form',
        'enableAjaxValidation' => false,
        'type'                 => 'inline',
        'htmlOptions'          => array('class' => 'well')
    )
); ?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'key', array('class' => 'span2')); ?>
<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5')); ?>
<?php echo $form->dropDownList($model, 'input_type', $model->statusInputType->getList(), array('class' => 'span2')); ?>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('CatalogModule.catalog', 'Create') : Yii::t('CatalogModule.catalog', 'Save'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>

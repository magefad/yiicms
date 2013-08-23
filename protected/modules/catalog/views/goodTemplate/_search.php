<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model GoodTemplate
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )
); ?>

<?php echo $form->textFieldRow($model, 'key',array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'name',array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'input_type',array('class' => 'span5')); ?>
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

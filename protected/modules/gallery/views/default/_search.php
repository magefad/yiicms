<?php
/**
 * @var $form TbActiveForm
 * @var $this Controller
 * @var $model Gallery
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>

<?php echo $form->textFieldRow($model, 'id', array('class' => 'span5', 'maxlength' => 10)); ?>
<?php echo $form->textFieldRow($model, 'title', array('class' => 'span5')); ?>
<?php echo $form->textAreaRow($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
<?php echo $form->textFieldRow($model, 'keywords', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'slug', array('class' => 'span5')); ?>
<?php echo $form->dropDownListRow($model, 'status', $model->statusMain->getList()); ?>
<?php echo $form->textFieldRow($model, 'sort_order', array('class' => 'span5', 'maxlength' => 10)); ?>

<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('gallery', 'Искать'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>

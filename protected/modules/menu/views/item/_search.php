<?php
/**
 * @var $model Item
 * @var $form TbActiveForm
 * @var $this Controller
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )
); ?>
<?php echo $form->textFieldRow($model, 'id', array('class' => 'span5', 'maxlength' => 10)); ?>
<?php echo $form->textFieldRow($model, 'parent_id', array('class' => 'span5', 'maxlength' => 10)); ?>
<?php echo $form->textFieldRow($model, 'menu_id', array('class' => 'span5', 'maxlength' => 10)); ?>
<?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 255)); ?>
<?php echo $form->textFieldRow($model, 'href', array('class' => 'span5', 'maxlength' => 255)); ?>
<?php echo $form->textFieldRow($model, 'type', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'access', array('class' => 'span5', 'maxlength' => 255)); ?>
<?php echo $form->textFieldRow($model, 'sort', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'status', array('class' => 'span5')); ?>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'type'     => 'primary',
        'label'    => Yii::t('menu', 'Искать'),
    )
); ?>
</div>
<?php $this->endWidget(); ?>

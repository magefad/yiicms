<?php
/**
 * @var $form TbActiveForm
 * @var $this Controller
 * @var $model News
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>

<?php echo $form->textFieldRow($model, 'id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'create_time', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'update_time', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'date', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 150)); ?>
<?php echo $form->textFieldRow($model, 'slug', array('class' => 'span5', 'maxlength' => 150)); ?>
<?php echo $form->textFieldRow($model, 'body_cut', array('class' => 'span5', 'maxlength' => 400)); ?>
<?php echo $form->textAreaRow($model, 'body', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
<?php echo $form->textFieldRow($model, 'user_id', array('class' => 'span5', 'maxlength' => 11)); ?>
<?php echo $form->dropDownListRow(
    $model,
    'status',
    $model->getStatusList(),
    array('empty' => Yii::t('news', '- любой -'))
); ?>
<?php echo $form->checkBoxRow($model, 'is_protected', $model->getProtectedStatusList()); ?>
<?php echo $form->textFieldRow($model, 'keywords', array('class' => 'span5', 'maxlength' => 150)); ?>
<?php echo $form->textFieldRow($model, 'description', array('class' => 'span5', 'maxlength' => 250)); ?>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('news', 'Искать'),
    )
); ?>
</div>
<?php $this->endWidget(); ?>

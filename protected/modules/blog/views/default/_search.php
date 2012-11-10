<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model Blog
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )
); ?>

<?php echo $form->textFieldRow($model, 'id', array('class' => 'span5', 'maxlength' => 10)); ?>
<?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 200)); ?>
<?php echo $form->textAreaRow($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
<?php echo $form->textFieldRow($model, 'slug', array('class' => 'span5', 'maxlength' => 200)); ?>
<?php echo $form->dropDownListRow($model, 'type', $model->statusType->getList()); ?>
<?php echo $form->dropDownListRow($model, 'status', $model->statusMain->getList()); ?>
<?php echo $form->textFieldRow($model, 'create_user_id', array('class' => 'span5', 'maxlength' => 10)); ?>
<?php echo $form->textFieldRow($model, 'update_user_id', array('class' => 'span5', 'maxlength' => 10)); ?>
<?php echo $form->textFieldRow($model, 'create_time', array('class' => 'span5', 'maxlength' => 19)); ?>
<?php echo $form->textFieldRow($model, 'update_time', array('class' => 'span5', 'maxlength' => 19)); ?>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('BlogModule.blog', 'Search'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>

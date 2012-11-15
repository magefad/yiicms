<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model Blog
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'blog-form',
        'type'                   => 'horizontal',
        'focus'                  => array($model, 'title'),
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'clientOptions'          => array(
            'validateOnSubmit' => true
        ),
        'htmlOptions'            => array('class' => 'well'),
    )
); ?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 200)); ?>
<?php echo $form->textAreaRow($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
<?php echo $form->textFieldRow($model, 'slug', array('class' => 'span5', 'maxlength' => 200)); ?>
<?php echo $form->dropDownListRow($model, 'type', $model->statusType->getList()); ?>
<?php echo $form->dropDownListRow($model, 'status', $model->statusMain->getList()); ?>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('BlogModule.blog', 'Create') : Yii::t('BlogModule.blog', 'Save'),
    )
); ?>
</div>

<?php
$this->endWidget();
if ($model->isNewRecord) {
    $this->widget('ext.SyncTranslit.SyncTranslit', array('textAttribute' => 'Blog_title'));
}
?>

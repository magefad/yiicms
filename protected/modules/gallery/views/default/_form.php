<?php
/**
 * @var $model Gallery
 * @var $form TbActiveForm
 * @var $this Controller
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'gallery-form',
        'type'                   => 'horizontal',
        'focus'                  => array($model, 'title'),
        'htmlOptions'            => array('class' => 'well'),
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'clientOptions'          => array(
            'validateOnSubmit' => true,
        )
    )
); ?>

<p class="alert alert-info"><?php echo Yii::t(
    'gallery',
    'Поля, отмеченные <span class="required">*</span> обязательны для заполнения.'
)?></p>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'title', array('class' => 'span5')); ?>
<?php echo $form->textAreaRow($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
<?php echo $form->textFieldRow($model, 'keywords', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'slug',array('class'  => 'span5')); ?>
<?php echo $form->dropDownListRow($model, 'status', $model->statusMain->getList()); ?>
<?php echo $form->textFieldRow($model, 'sort_order', array('class' => 'span5', 'maxlength' => 10)); ?>

<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'   => 'submit',
        'type'         => 'primary',
        'label'        => $model->isNewRecord ? Yii::t('gallery', 'Добавить') : Yii::t('gallery', 'Сохранить'),
    )
); ?>
</div>

<?php
$this->endWidget();
if ($model->isNewRecord) {
    $this->widget('ext.syncTranslit.SyncTranslit', array('textAttribute' => 'Gallery_title'));
}
?>

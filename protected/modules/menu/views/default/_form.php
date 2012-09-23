<?php
/**
 * @var $model Menu
 * @var $form TbActiveForm
 * @var $this Controller
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'menu-form',
        'focus'                  => array($model, 'name'),
        'htmlOptions'            => array('class' => 'well'),
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'clientOptions'          => array(
            'validateOnSubmit' => true,
        )
    )
); ?>
<p class="alert alert-info">Поля, отмеченные <span class="required">*</span> обязательны для заполнения</p>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 300)); ?>
<?php echo $form->textFieldRow($model, 'code', array('class' => 'span5', 'maxlength' => 100)); ?>
<?php echo $form->textFieldRow($model, 'description', array('class' => 'span5', 'maxlength' => 300)); ?>
<?php echo $form->dropDownListRow($model, 'status', $model->getStatusList()); ?>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('menu', 'Добавить') : Yii::t('menu', 'Сохранить'),
    )
); ?>
</div>
<?php $this->endWidget(); ?>

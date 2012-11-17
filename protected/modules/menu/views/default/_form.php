<?php
/**
 * @var $form TbActiveForm
 * @var $this Controller
 * @var $model Menu|NestedSetBehavior
 * @var $root bool
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'menu-form',
        'type'                   => 'horizontal',
        'focus'                  => array($model, 'title'),
        'htmlOptions'            => array('class' => 'well'),
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'clientOptions'          => array(
            'validateOnSubmit' => true,
        ),
    )
); ?>
<p class="alert alert-info"><?php echo Yii::t('menu', 'Поля, отмеченные <span class="required">*</span> обязательны для заполнения.')?></p>
<?php echo $form->errorSummary($model); ?>
<?php if (!$root): ?>
    <?php if ($model->isNewRecord): ?>
        <?php echo $form->dropDownListRow($model, 'root', $model->getParentsData()); ?>
    <?php else: ?>
    <div class="control-group">
    <?php echo CHtml::label($model->getAttributeLabel('root'), 'parentId', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo CHtml::dropDownList('parentId', $model->parentId, $model->getParentsData()); ?>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>
<?php echo $form->textFieldRow($model, 'title'); ?>
<?php if ($root): ?>
    <?php echo $form->textFieldRow($model, 'code'); ?>
<?php else: ?>
    <?php echo $form->textFieldRow($model, 'href'); ?>
<?php endif; ?>
<?php echo $form->dropDownListRow($model, 'access', $model->accessList, array('empty' => 'Все')); ?>
<?php echo $form->dropDownListRow($model, 'status', $model->statusMain->getList()); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'   => 'submit',
	'type'         => 'primary',
	'label'        => $model->isNewRecord ? Yii::t('menu', 'Добавить') : Yii::t('menu', 'Сохранить'),
)); ?>
</div>
<?php $this->endWidget(); ?>

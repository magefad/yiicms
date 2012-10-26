<?php
/**
 * @var $form TbActiveForm
 * @var $this Controller
 * @var $model Item
 */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'item-form',
    'type'                   => 'horizontal',
	'focus'                  => array($model, 'title'),
	'htmlOptions'            => array('class' => 'well'),
	'enableAjaxValidation'   => false,
	'enableClientValidation' => true,
	'clientOptions'          => array(
    'validateOnSubmit' => true,
),
)); ?>
<p class="alert alert-info"><?php echo Yii::t('menu', 'Поля, отмеченные <span class="required">*</span> обязательны для заполнения.')?></p>
<?php echo $form->errorSummary($model); ?>

<?php echo $form->dropDownListRow($model, 'menu_id', CHtml::listData(Menu::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('menu', ' -выберите меню- '))); ?>
<?php echo $form->dropDownListRow($model, 'parent_id', $model->parentList); ?>
<?php echo $form->textFieldRow($model, 'title', array('maxlength' => 100)); ?>
<?php echo $form->textFieldRow($model, 'href', array('maxlength' => 200)); ?>
<?php #echo $form->textFieldRow($model,'type',array('class' =>'span5')); ?>
<?php echo $form->dropDownListRow($model, 'access', $model->accessList, array('empty' => 'Все')); ?>
<?php echo $model->sortable->dropDownListRow($form); ?>
<?php echo $form->dropDownListRow($model, 'status', $model->getStatusList()); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'   => 'submit',
	'type'         => 'primary',
	'label'        => $model->isNewRecord ? Yii::t('menu', 'Добавить') : Yii::t('menu', 'Сохранить'),
)); ?>
</div>
<?php $this->endWidget(); ?>

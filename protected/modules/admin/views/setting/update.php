<?php
/**
 * User: fad
 * Date: 18.09.12
 * Time: 16:38
 * @var $settings Setting[]
 * @var $form TbActiveForm
 * @var $this Controller
 * @var $module CModule
 */
$this->widget('bootstrap.widgets.TbAlert', array(
	'alerts'   => array('success', 'error'),
));
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'          => 'horizontalForm',
	'type'        => 'horizontal',
	'htmlOptions' => array('class' => 'well')
));
?>
<fieldset>
	<legend><?php echo Yii::t('admin', 'Настройки') . ' ' . $module->name?></legend>
	<?php foreach ($settings as $key => $setting):?>
	<?php
		echo $form->hiddenField($setting, "[$key]module_id");
		echo $form->hiddenField($setting, "[$key]key");
		echo $form->{$setting->valueTag.'Row'}($setting, "[$key]value", $setting->valueValue);
	?>
	<?php endforeach; ?>
</fieldset>
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => Yii::t('setting', 'Сохранить'))); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => Yii::t('setting', 'Сбросить'))); ?>
</div>

<?php $this->endWidget(); ?>
<?php
/**
 * @var $settings Setting[]
 * @var $form TbActiveForm
 * @var $this Controller
 * @var $module WebModule
 */
$this->breadcrumbs = array(
	Yii::t('AdminModule.admin', 'Admin CP') => array('/admin'),
	$module->name => array('/' . $module->id . '/default/admin'),
	Yii::t('AdminModule.admin', 'Settings'),
);

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'          => 'horizontalForm',
	'type'        => 'horizontal',
	'htmlOptions' => array('class' => 'well')
));
?>
<fieldset>
	<legend><?php echo Yii::t('AdminModule.admin', 'Settings') . ' ' . $module->name?></legend>
    <?php foreach ($settings as $key => $setting): ?>
    <?php
    echo $form->hiddenField($setting, "[$key]module_id");
    echo $form->hiddenField($setting, "[$key]key");
    if (count($setting->data)) {
        echo $form->{$setting->tag . 'Row'}($setting, "[$key]value", $setting->data, $setting->htmlOptions);
    } else {
        echo $form->{$setting->tag . 'Row'}($setting, "[$key]value", $setting->htmlOptions);
    }
    ?>
    <?php endforeach; ?>
</fieldset>
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => Yii::t('AdminModule.settings', 'Save'))); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => Yii::t('AdminModule.settings', 'Default'))); ?>
</div>

<?php $this->endWidget(); ?>

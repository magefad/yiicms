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
$this->breadcrumbs = array(
	Yii::t('admin', 'Админка') => array('/admin'),
	Yii::t('admin', $module->name) => array('/' . $module->id . '/default/admin'),
	Yii::t('admin', 'Настройки'),
);

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'          => 'horizontalForm',
	'type'        => 'horizontal',
	'htmlOptions' => array('class' => 'well')
));
?>
<fieldset>
	<legend><?php echo Yii::t('admin', 'Настройки') . ' ' . $module->name?></legend>
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
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => Yii::t('setting', 'Сохранить'))); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => Yii::t('setting', 'Сбросить'))); ?>
</div>

<?php $this->endWidget(); ?>
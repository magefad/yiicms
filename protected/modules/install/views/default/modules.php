<?php
/**
 * modules.php class file.
 *
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 * @var $this Controller
 * @var $form TbActiveForm
 * @var $model Modules
 * @var $requiredModules array
 */
?>
<h1><?php echo Yii::t('InstallModule.modules', 'Install modules'); ?></h1>
<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'modules-form',
        'htmlOptions'            => array('class' => 'well'),
        'type'                   => 'horizontal',
        'enableAjaxValidation'   => true,
        'enableClientValidation' => true,
        'clientOptions'          => array(
            'validateOnSubmit' => true
        )
    )
);
echo $form->errorSummary($model);
echo $form->textFieldRow($model, 'username');
echo $form->textFieldRow($model, 'email');
echo $form->passwordFieldRow($model, 'password');
echo $form->passwordFieldRow($model, 'passwordConfirm');
?>
<div class="control-group">
    <label class="control-label" for="Modules_modules"><?php echo Yii::t('InstallModule.modules', 'Required modules'); ?></label>
    <div class="controls">
        <?php echo CHtml::checkBoxList(
        'requiredModules',
        array_keys($model->getRequiredModules()),
        $model->getRequiredModules(),
        array(
            'disabled' => true,
            'template' => '<label class="checkbox">{input} {label}</label>',
            'separator' => '',
        )
    );
        ?>
    </div>
</div>
<?php
echo $form->checkBoxListRow($model, 'modules', $model->getAvailableModules());
?>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => Yii::t('InstallModule.main', 'Next step'))); ?>
</div>

<?php $this->endWidget(); ?>
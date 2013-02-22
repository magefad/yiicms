<?php
/**
 * database.php class file.
 *
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
/**
 * @var $this Controller
 * @var $model Database
 * @var $form TbActiveForm
 */
?>
<h1><?php echo Yii::t('InstallModule.database', 'Create Database connection'); ?></h1>
<?php
Yii::app()->user->setFlash('info', Yii::t('InstallModule.database', 'Correct working is guaranteed only with the use of the database <strong>MySQL</strong> or <strong>SQLite</strong>. Working with other databases is not tested!'));
$this->widget('bootstrap.widgets.TbAlert');
Yii::app()->clientScript->registerScript('database', '
function formFields(dbType) {
    if (dbType == "sqlite") {
        jQuery("#Database_host, #Database_username, #Database_password").parent().parent().hide();
    } else {
        jQuery("#Database_host, #Database_username, #Database_password").parent().parent().show();
    }
}
formFields("'.$model->dbType.'");
', CClientScript::POS_END);
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'database-form',
        'htmlOptions'            => array('class' => 'well'),
        'type'                   => 'horizontal',
        'enableAjaxValidation'   => true,
        /*'enableClientValidation' => true,
        'clientOptions'          => array(
            'validateOnSubmit' => true
        )*/
    )
);
echo $form->errorSummary($model);
echo $form->dropDownListRow($model, 'dbType', $model->dbSupported(), array('onchange' => 'formFields(this.value)'));
echo $form->textFieldRow($model, 'host');
echo $form->textFieldRow($model, 'dbName');
echo $form->textFieldRow($model, 'username');
echo $form->passwordFieldRow($model, 'password');
echo $form->textFieldRow($model, 'tablePrefix');
?>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => Yii::t('InstallModule.main', 'Next step'))); ?>
</div>

<?php $this->endWidget(); ?>
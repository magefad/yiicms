<?php
/**
 * @var $this Controller
 */
$this->pageTitle   = Yii::app()->name . ' - ' . Yii::t('contact', 'Контакты');
$this->breadcrumbs = array(
    Yii::t('contact', 'Контакты'),
);
$pageSlug          = str_replace('page/', '', Yii::app()->request->getPathInfo()); //@todo BAD STR_REPLACE!!!
/** @var $page Page */
$page         = Page::model()->findBySlug($pageSlug);
$flashSuccess = (Yii::app()->user->hasFlash('success') == 1) ? true : false;
?>
<?php if ($flashSuccess): ?>
<div class="alert in alert-block fade alert-success">
    <a class="close" data-dismiss="alert">×</a>
    <?php echo Yii::app()->user->getFlash('success')?>
</div>
<?php endif; ?>

<?php
if ($page) {
    $this->pageTitle = $page->title;
    echo $page->body;
}
?>

<?php if (!$flashSuccess): ?>
<p class="alert alert-info">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>
<div class="form">
	<?php
	/** @var $model ContactForm */
	/** @var $form TbActiveForm */
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'                     => 'contact-form',
	'type'					 => 'horizontal',
	'focus'                  => $page ? null : array($model, 'name'),
	/*'enableAjaxValidation' =>	true,*/
	'enableClientValidation' => true,
	'clientOptions'          => array(
		'validateOnSubmit' => true,
	),
)); ?>
    <fieldset>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->textFieldRow($model, 'name'); ?>
        <?php echo $form->textFieldRow($model, 'email'); ?>
        <?php echo $form->textFieldRow($model, 'city'); ?>
        <?php echo $form->textFieldRow($model, 'phone', array('style' => 'margin-top:8px')); ?>
        <?php echo $form->textAreaRow($model, 'body'); ?>
        <?php if (CCaptcha::checkRequirements() && Yii::app()->getModule('contact')->captchaRequired): ?>
        <?php echo $form->captchaRow(
            $model,
            'verifyCode',
            array('class' => 'xlarge'),
            array('clickableImage' => true, 'showRefreshButton' => 0)
        ); ?>
        <?php endif; ?>
    </fieldset>
    <div class="form-actions">
        <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type'      => 'primary',
            'icon'      => 'ok white',
            'label'     => Yii::t('contact', 'Отправить')
        )
    ); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
<?php endif; ?>
<?php
/**
 * @var $this Controller
 */
$this->pageTitle   = Yii::app()->name . ' - ' . Yii::t('contact', 'Контакты');
$this->breadcrumbs = array(Yii::t('contact', 'Контакты'));

Yii::import('application.modules.page.models.*');
$pageSlug = str_replace('page/', '', Yii::app()->getRequest()->getPathInfo());
if ($page = Page::model()->findBySlug($pageSlug)) {
    $this->pageTitle   = $page->title;
    $this->keywords    = $page->keywords;
    $this->description = $page->description;
    $this->breadcrumbs = null;
    echo $page->content;
}
?>

<?php if (Yii::app()->user->hasFlash('success')): ?>
<?php
    $this->beginWidget('bootstrap.widgets.TbHeroUnit', array('heading' => 'Спасибо!'));
    echo '<p>' . Yii::app()->user->getFlash('success') . '</p><p>&nbsp;</p>';
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'type'  => 'primary',
            'size'  => 'large',
            'label' => 'Перейти на главную страницу',
            'url'   => '/',
        )
    );
    $this->endWidget();
    ?>
<?php else: ?>
<p class="alert alert-info">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>
<div class="form">
	<?php
	/**
     * @var $model ContactForm
     * @var $form TbActiveForm
     */
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'                     => 'contact-form',
	'type'					 => 'horizontal',
	'focus'                  => $page ? null : array($model, 'name'),
	/*'enableAjaxValidation' =>	true,*/
	'enableClientValidation' => true,
	'clientOptions'          => array(
		'validateOnSubmit' => true,
	),
    'htmlOptions'            => array('class' => 'well'),
)); ?>
    <fieldset>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->textFieldRow($model, 'name'); ?>
        <?php echo $form->textFieldRow($model, 'email'); ?>
        <?php echo $form->textFieldRow($model, 'city'); ?>
        <?php echo $form->textFieldRow($model, 'phone', array('style' => 'margin-top:8px')); ?>
        <?php echo $form->textAreaRow($model, 'body'); ?>
        <?php if (CCaptcha::checkRequirements() && $this->module->captchaRequired): ?>
            <?php echo $form->captchaRow($model, 'verifyCode', array('class' => 'xlarge'), array('clickableImage' => true, 'showRefreshButton' => 0)); ?>
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
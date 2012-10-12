<?php
/**
 * @var $form TbActiveForm
 * @var $this Controller
 * @var $model Page
 * @var $pages array
 */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'                   => 'page-form',
	'focus'                => array($model, 'name'),
	'htmlOptions'          => array('class' => 'form-inline well'),
	'enableAjaxValidation' => false,
));

Yii::app()->clientScript->registerScript('ajaxPreview', '
$("#ajaxPreview").click(function(e) {
	e.preventDefault();
	$.ajax({
  		type: "POST",
  		url: "'. $this->createUrl('/page/default/ajaxPreview') .'",
  		data: { body: $("#Page_body").html() },
	}).success(function( data ) {
		var win = window.open("","Preview","width="+(screen.width-10)+",height="+(screen.height-100)+"");
		with(win.document) {
			open();
			write(data);
			close();
    	}
	});
});
', CClientScript::POS_READY);
?>
	<!-- <p class="alert alert-info"><?php echo Yii::t('page', 'Поля, отмеченные <span class="required">*</span> обязательны для заполнения.')?></p> -->
	<?php echo $form->errorSummary($model); ?>
   	<div class="row-fluid control-group">
		<div class="span3 mytip" title="<?php if ( !$model->isNewRecord ) echo $model->getAttributeLabel('parent_id');?>">
			<?php echo $form->dropDownList($model, 'parent_id', $pages, array('empty' => Yii::t('page', '- нет родительской страницы -'))); ?>
		</div>
		<div class="span3 mytip" title="<?php if ( !$model->isNewRecord ) echo $model->getAttributeLabel('status');?>">
			<?php echo $form->dropDownList($model, 'status', $model->getStatusList()) ?>
		</div>
		<div class="span1 mytip" title="<?php if ( !$model->isNewRecord ) echo $model->getAttributeLabel('menu_order');?>">
			<?php echo $form->textField($model, 'menu_order'); ?>
		</div>
	</div>
	<div class="row-fluid control-group">
		<div class="span3 mytip" title="<?php if ( !$model->isNewRecord ) echo $model->getAttributeLabel('name');?>">
			<?php echo $form->textField($model, 'name', array('style' => 'width: 220px!important', 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('name'))); ?>
		</div>
		<div class="span3 mytip" title="<?php if ( !$model->isNewRecord ) echo $model->getAttributeLabel('title');?>">
			<?php echo $form->textField($model, 'title', array('style' => 'width: 220px!important', 'maxlength' => 200, 'placeholder' => $model->getAttributeLabel('title'))); ?>
		</div>
		<div class="span4 mytip" title="<?php if ( !$model->isNewRecord ) echo $model->getAttributeLabel('slug');?>">
			<?php echo $form->textField($model, 'slug', array('maxlength' => 200, 'placeholder' => $model->getAttributeLabel('slug'))); ?>
		</div>
	</div>

	<div>
	<?php
		$this->widget('ext.tinymce.TinyMce', array('model' => $model, 'attribute' => 'body', 'settings' => array('content_css' => Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('ext.bootstrap.assets')).'/css/bootstrap.min.css')));
	?>
	</div>
	<div>&nbsp;</div>
	<div class="row-fluid control-group mytip" title="<?php if ( !$model->isNewRecord ) echo $model->getAttributeLabel('keywords');?>">
		<?php echo $form->textField($model, 'keywords', array('class' => 'span5', 'maxlength' => 200, 'placeholder' => $model->getAttributeLabel('keywords'))); ?>
	</div>
	<div class="row-fluid control-group mytip" title="<?php if ( !$model->isNewRecord ) echo $model->getAttributeLabel('description');?>">
		<?php echo $form->textField($model, 'description', array('class' => 'span5', 'maxlength' => 250, 'placeholder' => $model->getAttributeLabel('description'))); ?>
	</div>
	<div class="row-fluid control-group">
		<div class="row-fluid control-group">
			<?php echo $form->checkBoxRow($model, 'is_protected'); ?>
		</div>
	</div>
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType' => 'submit',
	'type'       => 'primary',
	'label'      => $model->isNewRecord ? Yii::t('page', 'Добавить') : Yii::t('page', 'Сохранить')
));
$this->endWidget();
?>

<?php
/**
 * @var $form TbActiveForm
 * @var $model Page
 * @var $this Controller
 */
?>
<div class="row-fluid">
    <div class="span2 control-group">
        <?php echo $form->textFieldRow($model, 'name', array('style' => 'width: 100%')); ?>
    </div>
    <div class="span4 control-group">
        <?php echo $form->textFieldRow($model, 'title', array('style' => 'width: 100%')); ?>
    </div>
    <div class="span3 control-group">
        <?php echo $form->textFieldRow($model, 'slug', array('style' => 'width: 100%')); ?>
    </div>
    <div class="span3 control-group">
        <?php echo $form->textFieldRow($model, 'keywords', array('style' => 'width: 93%', 'placeholder' => Yii::t('page', 'Через запятую'))); ?>
    </div>
</div>
<div class="row-fluid control-group">
    <span class="span2">
        <?php echo $form->labelEx($model, 'description', array('style' => 'width: 100%; padding-top: 5px; text-align: right')); ?>
    </span>
    <span class="span10">
        <?php echo $form->textField($model, 'description', array('style' => 'width: 98%')); ?>
        <?php echo $form->error($model, 'description'); ?>
    </span>
</div>
<?php
if ($model->isNewRecord) {
    $this->widget('ext.syncTranslit.SyncTranslit', array('textAttribute' => 'Page_title'));
}
<?php
/**
 * @var $form TbActiveForm
 * @var $model Page
 * @var $pages array
 */
?>
<div class="row-fluid">
    <?php echo $form->textFieldRow($model, 'keywords', array('class' => 'span12', 'maxlength' => 200, 'placeholder' => Yii::t('page', 'Ключевые слова (словосочетания) рекоммендуется вводить через запятую'))); ?>
    <?php echo $form->textFieldRow($model, 'description', array('class' => 'span12', 'maxlength' => 250)); ?>
</div>
<div class="row-fluid">
    <span class="span2">
        <?php echo $form->dropDownListRow($model, 'parent_id', $pages, array('style' => 'width: 100% !important;', 'empty' => Yii::t('page', '- нет родительской страницы -'))); ?>
    </span>
    <span class="span3">
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('style' => 'width: 100% !important')) ?>
    </span>
    <span class="span1">
        <?php echo $form->textFieldRow($model, 'menu_order', array('style' => 'width: 100% !important')); ?>
    </span>
</div>
<?php echo $form->checkBoxRow($model, 'is_protected'); ?>

<?php
/**
 * @var $form TbActiveForm
 * @var $model Page
 */
?>
<div class="row-fluid">
    <span class="span2">
        <?php echo $form->dropDownListRow($model, 'parent_id', $model->treeArray->listData, array('style' => 'width: 100% !important;', 'empty' => Yii::t('page', '- нет родительской страницы -'))); ?>
    </span>
    <span class="span3">
        <?php echo $form->dropDownListRow($model, 'status', $model->statusMain->getList(), array('style' => 'width: 100% !important')) ?>
    </span>
    <span class="span1">
        <?php echo $form->textFieldRow($model, 'sort_order', array('style' => 'width: 100% !important')); ?>
    </span>
</div>
<?php echo $form->checkBoxRow($model, 'is_protected'); ?>
<?php echo $form->checkBoxRow($model, 'rich_editor'); ?>
<?php
Yii::app()->clientScript->registerScript(
    'rich_editor',
    '
    $("#Page_rich_editor").change(function() {
        $("#' . $form->id . '").submit().fadeTo(2500, 0.4);
        $("input, select, textarea").attr("readonly", true);
    });
    '
);
?>

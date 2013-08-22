<?php
/**
 * @var $form TbActiveForm
 * @var $model Page
 * @var $this Controller
 */
?>
<div class="row-fluid">
    <span class="span3">
        <?php echo $form->dropDownListRow($model, 'parent_id', $model->treeArray->getListData(), array('style' => 'width: 100% !important;', 'empty' => Yii::t('PageModule.page', '- no parent page -'))); ?>
    </span>
    <span class="span2">
        <?php echo $form->dropDownListRow($model, 'status', $model->statusMain->getList(), array('style' => 'width: 100% !important')) ?>
    </span>
    <span class="span2">
        <?php echo $form->dropDownListRow($model, 'type', $model->statusType->getList(), array('empty' => Yii::t('zii', 'Not set'), 'style' => 'width: 100% !important')) ?>
    </span>
    <span class="span1">
        <?php echo $form->textFieldRow($model, 'sort_order', array('style' => 'width: 100% !important')); ?>
    </span>
</div>
<?php echo $form->checkBoxRow($model, 'is_protected'); ?>
<?php if ($model->slug != $this->getModule()->defaultPage) echo $form->checkBoxRow($model, 'rich_editor'); ?>
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

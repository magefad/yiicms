<?php
/**
 * @var $form TbActiveForm
 * @var $model Page
 */
?>
<div class="row-fluid">
    <span class="span3">
        <?php echo $form->textFieldRow($model, 'name', array('style' => 'width: 100% !important', 'maxlength' => 50)); ?>
    </span>
    <span class="span4">
        <?php echo $form->textFieldRow($model, 'title', array('style' => 'width: 100% !important', 'maxlength' => 200)); ?>
    </span>
    <span class="span5">
        <?php echo $form->textFieldRow($model, 'slug', array('style' => 'width: 90%', 'maxlength' => 200)); ?>
    </span>
</div>

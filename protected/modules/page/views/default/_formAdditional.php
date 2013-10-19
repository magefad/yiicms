<?php
/**
 * @var $form TbActiveForm
 * @var $model Page
 * @var $this Controller
 */
?>
<div class="row-fluid">
    <div class="row-fluid control-group">
        <span class="span2">
            <?php echo $form->labelEx($model, 'annotation', array('style' => 'width: 100%; padding-top: 5px; text-align: right')); ?>
        </span>
        <span class="span7">
            <?php echo $form->textArea($model, 'annotation', array('style' => 'width: 98%')); ?>
            <?php echo $form->error($model, 'annotation'); ?>
        </span>
        <span class="span3">
            <?php echo $form->datetimepickerRow($model, 'create_time'); ?>
        </span>
    </div>
    <div class="row-fluid control-group">
        <span class="span2">
            <?php echo $form->labelEx($model, 'image', array('style' => 'width: 100%; text-align: right')); ?>
        </span>
        <span class="span10">
            <?php
            if ($model->image) {
                echo CHtml::link(
                    CHtml::image(
                        $model->getThumbnailUrl(),
                        '',
                        array(
                            'style' => 'float: left; height: 30px; padding-right: 10px;',
                            'rel'   => 'tooltip',
                            'title' => Yii::t('PageModule.page', 'Show thumbnail')
                        )
                    ),
                    $model->getThumbnailUrl(),
                    array('target' => '_blank')
                );
            }
            echo $form->fileField($model, 'image') .
            $form->error($model, 'image') .
            $form->checkBox($model, 'onlyThumbnail') . ' ' .
            Yii::t('PageModule.page', 'Only small image (thumbnail)');
            ?>
        </span>
    </div>
</div>

<?php
/**
 * @var $model Comment
 * @var $this CController
 * @var $form TbActiveForm
 */
?>
<?php if (Yii::app()->user->isGuest && !$model->isNewRecord) { ?>
<div class="comment-not-logged">
    <?php echo Yii::t('CommentModule.comment', 'Sorry, you have to login to leave a comment.'); ?>
</div>
<?php } else { ?>
<div id="comment-form-<?php echo $model->isNewRecord ? 'new' : 'edit-' . $model->id; ?>" class="form">
    <?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'comment-form',
        'enableAjaxValidation' => false
    )
); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="control-group">
        <?php echo $form->textArea($model, 'text', array('class' => 'span4', 'rows' => 5, 'placeholder' => $model->getAttributeLabel('text'))); ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>
    <?php if (Yii::app()->user->isGuest && CCaptcha::checkRequirements()): ?>
        <div class="control-group">
            <?php echo $form->textField($model, 'verifyCode', array('placeholder' => $model->getAttributeLabel('verifyCode'))); ?>
            <?php $this->widget('CCaptcha', array('captchaAction' => Yii::app()->createUrl('/comment/default/captcha'), 'clickableImage' => true, 'showRefreshButton' => false)); ?>
            <?php echo $form->error($model, 'verifyCode'); ?>
        </div>
    <?php endif; ?>
    <div class="control-group">
        <?php if ($model->isNewRecord) {
        echo $form->hiddenField($model, 'model');
        echo $form->hiddenField($model, 'model_id');
        echo CHtml::ajaxSubmitButton(
            Yii::t('CommentModule.comment', 'Submit'),
            array('/comment/default/create'),
            array('replace' => '#comment-form-new'),
            array(
                'id'    => 'comment-submit' . (isset($ajaxId) ? $ajaxId : ''),
                'class' => 'btn btn-primary'
            )
        );
    } else {
        echo CHtml::ajaxSubmitButton(
            Yii::t('CommentModule.comment', 'Update'),
            array('/comment/default/update', 'id' => $model->id),
            array('replace' => '#comment-form-edit-' . $model->id),
            array(
                'id'    => 'comment-submit' . (isset($ajaxId) ? $ajaxId : ''),
                'class' => 'btn btn-primary'
            )
        );
    }
        ?>
    </div>
    <?php $this->endWidget() ?>
</div><!-- form -->
<?php
    Yii::app()->clientScript->registerScript(
        'submit',
        "$('#Comment_text').keydown(function (e) {if (e.ctrlKey && e.keyCode == 13){\$('#comment-submit').click();}});"
    );
} ?>

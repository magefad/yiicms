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
<?php if ($model->isNewRecord): ?>
    <p>
        <button class="btn btn-small" type="button" id="toggle-comment-form" onclick='$("#comment-form").toggle("fast")'>
            <i class="icon-arrow-down"></i><?php echo Yii::t('CommentModule.comment', 'Post Comment');?>
        </button>
    </p>
<?php endif; ?>
    <?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'comment-form',
        'htmlOptions'          => array('style' => $model->isNewRecord && !count($model->errors) ? 'display:none' : ''),
        'enableAjaxValidation' => false
    )
); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="control-group">
        <?php echo $form->textArea($model, 'content', array('class' => 'span4', 'rows' => 5, 'placeholder' => $model->getAttributeLabel('content'))); ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>
    <?php if (Yii::app()->user->isGuest): ?>
    <div class="control-group">
        <div class="control-group">
            <?php echo $form->textField($model, 'username', array('placeholder' => $model->getAttributeLabel('username'))); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
    </div>
    <?php if (CCaptcha::checkRequirements()): ?>
        <div class="control-group">
            <?php echo $form->textField($model, 'verifyCode', array('placeholder' => $model->getAttributeLabel('verifyCode'))); ?>
            <?php $this->widget('CCaptcha', array('captchaAction' => Yii::app()->createUrl('/comment/default/captcha'), 'clickableImage' => true, 'showRefreshButton' => false)); ?>
            <?php echo $form->error($model, 'verifyCode'); ?>
        </div>
    <?php endif; ?>
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
<?php } ?>

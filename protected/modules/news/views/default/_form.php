<?php
/**
 * @var $model News
 * @var $form TbActiveForm
 * @var $this Controller
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'news-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    )
); ?>

<p class="alert alert-info"><?php echo Yii::t(
    'news',
    'Поля, отмеченные <span class="required">*</span> обязательны для заполнения.'
)?></p>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->labelEx($model, 'date'); ?>
<?php $this->widget(
    'zii.widgets.jui.CJuiDatePicker',
    array(
        'model'     => $model,
        'attribute' => 'date',
        'language'  => Yii::app()->language,
        'options'   => array(
            'dateFormat' => 'dd.mm.yy',
        ),
    )
); ?>
<?php echo $form->error($model, 'date'); ?>
<?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 150)); ?>
<?php echo $form->textFieldRow($model, 'slug', array('class' => 'span5', 'maxlength' => 150)); ?>

<?php if ($model->image): ?>
<p><?php echo CHtml::image($model->getThumbnailUrl()); ?></p>
<?php endif; ?>
<?php echo $form->fileFieldRow($model, 'image'); ?>
<?php echo $form->labelEx($model, 'body_cut'); ?>
<?php
$this->widget(
    'ext.tinymce.TinyMce',
    array(
        'model'     => $model,
        'attribute' => 'body_cut',
        'settings'  => array(
            'height'                  => '25px',
            'theme_advanced_buttons1' => 'bold,italic,underline,strikethrough,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,cleanup,|,media,|,forecolor,backcolor,|,insertdate,inserttime,|,preview,|,spellchecker',
            'theme_advanced_buttons2' => '',
            'theme_advanced_buttons3' => '',
            'content_css'             => Yii::app()->assetManager->getPublishedUrl(
                Yii::getPathOfAlias('ext.bootstrap.assets')
            ) . '/css/bootstrap.min.css, /css/main.css'
        )
    )
);
?>
<div>&nbsp;</div>
<?php echo $form->labelEx($model, 'body'); ?>
<?php $this->widget(
    'ext.tinymce.TinyMce',
    array(
        'model'     => $model,
        'attribute' => 'body',
        'settings'  => array(
            'content_css' => Yii::app()->assetManager->getPublishedUrl(
                Yii::getPathOfAlias('ext.bootstrap.assets')
            ) . '/css/bootstrap.min.css'
        )
    )
); ?>

<?php echo $form->dropDownListRow($model, 'status', $model->StatusList); ?>
<?php echo $form->checkBoxRow($model, 'is_protected', $model->ProtectedStatusList); ?>
<?php echo $form->textFieldRow($model, 'keywords', array('class' => 'span5', 'maxlength' => 150)); ?>
<?php echo $form->textFieldRow($model, 'description', array('class' => 'span5', 'maxlength' => 250)); ?>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'   => 'submit',
        'type'         => 'primary',
        'label'        => $model->isNewRecord ? Yii::t('news', 'Добавить') : Yii::t('news', 'Сохранить'),
    )
); ?>
</div>
<?php $this->endWidget(); ?>

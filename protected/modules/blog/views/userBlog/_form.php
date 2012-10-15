<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model UserBlog
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'user-to-blog-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'horizontal',
        'htmlOptions'            => array('class' => 'well'),
        'inlineErrors'           => true,
    )
); ?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->dropDownListRow($model, 'user_id', CHtml::listData(User::model()->findAll(), 'id', 'username')); ?>
<?php echo $form->dropDownListRow($model, 'blog_id', CHtml::listData(Blog::model()->findAll(), 'id', 'title')); ?>
<?php echo $form->dropDownListRow($model, 'role', $model->getRoleList()); ?>
<?php echo $form->dropDownListRow($model, 'status', $model->getStatusList()); ?>
<?php echo $form->textFieldRow($model, 'note', array('class' => 'span5', 'maxlength' => 255)); ?>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('BlogModule.blog', 'Create') : Yii::t('BlogModule.blog', 'Save'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>

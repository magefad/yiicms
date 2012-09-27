<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model Post
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )
); ?>

<?php echo $form->textFieldRow($model, 'id', array('class' => 'span5', 'maxlength' => 10)); ?>
<?php echo $form->textFieldRow($model, 'blog_id', array('class' => 'span5', 'maxlength' => 10)); ?>
<?php echo $form->textFieldRow($model, 'create_user_id', array('class' => 'span5', 'maxlength' => 10)); ?>
<?php echo $form->textFieldRow($model, 'update_user_id', array('class' => 'span5', 'maxlength' => 10)); ?>
<?php echo $form->textFieldRow($model, 'create_time', array('class' => 'span5', 'maxlength' => 11)); ?>
<?php echo $form->textFieldRow($model, 'update_time', array('class' => 'span5', 'maxlength' => 11)); ?>
<?php echo $form->textFieldRow($model, 'publish_time', array('class' => 'span5', 'maxlength' => 11)); ?>
<?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 128)); ?>
<?php echo $form->textFieldRow($model, 'slug', array('class' => 'span5', 'maxlength' => 128)); ?>
<?php echo $form->textAreaRow($model, 'content', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
<?php echo $form->textFieldRow($model, 'keywords', array('class' => 'span5', 'maxlength' => 128)); ?>
<?php echo $form->textFieldRow($model, 'description', array('class' => 'span5', 'maxlength' => 255)); ?>
<?php echo $form->textFieldRow($model, 'link', array('class' => 'span5', 'maxlength' => 128)); ?>
<?php echo $form->textFieldRow($model, 'status', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'comment_status', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'access_type', array('class' => 'span5')); ?>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('blog', 'Search'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>

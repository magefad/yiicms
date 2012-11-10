<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model UserBlog
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>

<?php echo $form->textFieldRow($model, 'id', array('class' => 'span5', 'maxlength' => 10)); ?>
<?php echo $form->dropDownListRow($model, 'user_id', CHtml::listData(User::model()->findAll(), 'id', 'username')); ?>
<?php echo $form->dropDownListRow($model, 'blog_id', CHtml::listData(Blog::model()->findAll(), 'id', 'title')); ?>
<?php echo $form->dropDownListRow($model, 'role', $model->getRoleList()); ?>
<?php echo $form->dropDownListRow($model, 'status', $model->statusMain->getList()); ?>
<?php echo $form->textFieldRow($model, 'note', array('class' => 'span5', 'maxlength' => 255)); ?>
<?php echo $form->textFieldRow($model, 'create_time', array('class' => 'span5', 'maxlength' => 19)); ?>
<?php echo $form->textFieldRow($model, 'update_time', array('class' => 'span5', 'maxlength' => 19)); ?>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('BlogModule.blog', 'Search'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>

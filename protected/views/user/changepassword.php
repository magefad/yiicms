<?php
/**
 * User: fad
 * Date: 11.07.12
 * Time: 17:20
 */
$this->pageTitle = Yii::t('user', 'Изменение пароля');
$this->breadcrumbs = array(
	Yii::t('user', 'Пользователи') => array('/user/admin'),
	$model->username => array('view', 'id' => $model->id),
	Yii::t('user', 'Изменение'),
);

$this->menu = array(
	array('label' => Yii::t('user', 'Список'), 'url' => array('index')),
	array('label' => Yii::t('user', 'Добавить'), 'url' => array('create')),
	array('label' => Yii::t('user', 'Изменить'), 'url' => array('update', 'id' => $model->id)),
	array('label' => Yii::t('user', 'Удалить'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
	array('label' => Yii::t('user', 'Управление'), 'url' => array('admin')),
);
?>
<div class="form">
<?php
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'change-user-password-form',
	'enableClientValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
		),
		'htmlOptions' => array('class' => 'form-inline well'),
));
?>
	<?php echo $form->errorSummary($changePasswordForm); ?>
	<div class="row-fluid control-group">
		<?php echo $form->passwordField($changePasswordForm, 'password', array('placeholder' => 'Введите новый пароль')) ?>
		<?php echo $form->error($changePasswordForm, 'password'); ?>
	</div>
	<div class="row-fluid control-group">
		<?php echo $form->passwordField($changePasswordForm, 'cPassword', array('placeholder' => 'Повторите введеный пароль')) ?>
		<?php echo $form->error($changePasswordForm, 'cPassword'); ?>
	</div>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Сохранить')); ?>

	<?php $this->endWidget(); ?>
</div>
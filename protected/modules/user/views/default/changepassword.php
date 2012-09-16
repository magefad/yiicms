<?php
/**
 * User: fad
 * Date: 11.07.12
 * Time: 17:20
 */
/**
 * @var $model User
 * @var $form TbActiveForm
 * @var $changePasswordForm changePasswordForm
 * @var $this CController
 */

$this->pageTitle   = Yii::t('user', 'Изменение пароля');
$this->breadcrumbs = array(
	Yii::t('user', 'Пользователи') => array('admin'),
	$model->username               => array('view', 'id' => $model->id),
	Yii::t('user', 'Изменение'),
);

$this->menu = array(
	array('icon' => 'user', 'label' => Yii::t('user', 'Пользователи')),
	array('icon' => 'list-alt', 'label' => Yii::t('user', 'Управление'), 'url' => array('/user/default/admin/')),
	array('icon' => 'file', 'label' => Yii::t('user', 'Добавить'), 'url' => array('create')),
	array('icon' => 'pencil', 'label' => Yii::t('user', 'Изменить'), 'url' => array('update', 'id' => $model->id)),
	array('icon' => 'filter', 'label' => Yii::t('user', 'Роль доступа'), 'url' => array('/rights/assignment/user/', 'id' => $model->id), 'linkOptions' => array('target' => '_blank')),
	array(
		'icon'        => 'remove',
		'label'       => Yii::t('user', 'Удалить'),
		'url'         => '#',
		'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')
	),
);
?>
<div class="form">
	<?php
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'             => 'change-user-password-form',
		'enableClientValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
		), 'htmlOptions' => array('class' => 'form-inline well'),
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
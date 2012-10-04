<?php
/**
 * @var $data User
 * @var $this CController
 */
?>
<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
    <?php echo CHtml::encode($data->create_time); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
    <?php echo CHtml::encode($data->update_time); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('firstname')); ?>:</b>
    <?php echo CHtml::encode($data->firstname); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('lastname')); ?>:</b>
    <?php echo CHtml::encode($data->lastname); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
    <?php echo CHtml::encode($data->username); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
    <?php echo CHtml::encode($data->email); ?>
    <br/>

    <?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('salt')); ?>:</b>
	<?php echo CHtml::encode($data->salt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('access_level')); ?>:</b>
	<?php echo CHtml::encode($data->access_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_visit')); ?>:</b>
	<?php echo CHtml::encode($data->last_visit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registration_date')); ?>:</b>
	<?php echo CHtml::encode($data->registration_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registration_ip')); ?>:</b>
	<?php echo CHtml::encode($data->registration_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activation_ip')); ?>:</b>
	<?php echo CHtml::encode($data->activation_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('avatar')); ?>:</b>
	<?php echo CHtml::encode($data->avatar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('use_gravatar')); ?>:</b>
	<?php echo CHtml::encode($data->use_gravatar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activate_key')); ?>:</b>
	<?php echo CHtml::encode($data->activate_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email_confirm')); ?>:</b>
	<?php echo CHtml::encode($data->email_confirm); ?>
	<br />

	*/ ?>

</div>
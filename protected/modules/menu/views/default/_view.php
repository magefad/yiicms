<?php
/**
 * @var $data Menu
 */
?>
<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
    <?php echo CHtml::encode($data->title); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('href')); ?>:</b>
    <?php echo CHtml::encode($data->href); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
    <?php echo CHtml::encode($data->type); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('access')); ?>:</b>
    <?php echo CHtml::encode($data->access); ?>
    <br/>

    <?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>

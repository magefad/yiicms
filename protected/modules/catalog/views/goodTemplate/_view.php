<?php
/** @var $data GoodTemplate */
?>
<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->key), array('view','id'=>$data->key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>
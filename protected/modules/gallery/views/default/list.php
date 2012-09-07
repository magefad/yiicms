<?php
/**
 * User: fad
 * Date: 07.08.12
 * Time: 16:10
 */
?>
<h2>Альбомы</h2>
<ul class="unstyled">
	<?php foreach ($albums as $album): ?>
	<li><?php echo CHtml::link($album->name.' »', array('/album/'.$album->slug));?></li>
	<?php endforeach;?>
</ul>
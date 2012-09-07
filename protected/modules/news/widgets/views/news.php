<?php
/**
 * User: fad
 * Date: 27.07.12
 * Time: 16:59
 */
?>
<div class='portlet'>
	<div class='portlet-decoration'>
		<div class='portlet-title'>Новости</div>
	</div>
	<div class='portlet-content'>
		<ul class="unstyled">
			<?php foreach ($news as $new): ?>
			<li><?php echo CHtml::link($new->title.' »', array('/news/default/show', 'slug' => $new->slug));?></li>
			<?php endforeach;?>
		</ul>
	</div>
</div>
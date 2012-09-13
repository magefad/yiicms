<?php
/** @var $data News */
/** @var $thumbnailUrl string Thumbnail Image URL */
$thumbnailUrl = News::model()->findByPk($data->id)->getThumbnailUrl();
?>
<div style="margin-bottom: 20px;padding-bottom: 40px;clear: both">
	<h6><span class="label"><?php echo $data->date;?></span>
		<?php echo CHtml::link($data->title, array('default/show', 'slug' => $data->slug));?></h6>
	<?php
	if ( $thumbnailUrl )
	{
		echo CHtml::link(
			CHtml::image($thumbnailUrl, $data->title, array('style' => 'float:left;padding: 5px 10px 10px 0;width:100px')),
			array('default/show', 'slug' => $data->slug)
		);
	}
	echo $data->body_cut;?>
</div>
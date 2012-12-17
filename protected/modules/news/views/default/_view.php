<?php
/**
 * @var $data News
 * @var $thumbnailUrl string Thumbnail Image URL
 */
?>
<div class="media">
<?php if ($thumbnailUrl = News::model()->findByPk($data->id)->getThumbnailUrl()): ?>
    <?php echo CHtml::link(CHtml::image($thumbnailUrl, $data->title, array('class' => 'media-object img-rounded')), array('default/show', 'slug' => $data->slug), array('class' => 'pull-left'));?>
<?php else: ?>
    <div class="well pull-left">
        <?php echo CHtml::link('<i class="icon-question-sign"></i>', array('default/show', 'slug' => $data->slug), array('class' => 'muted media-object')); ?>
    </div>
<?php endif; ?>
    <div class="media-body">
        <h2 class="media-heading"><?php echo CHtml::link($data->title, array('default/show', 'slug' => $data->slug));?></h2>
        <span class="label"><?php echo $data->date;?></span>
        <?php echo $data->content_short;?>
    </div>
</div>
<div style="clear: both">&nbsp;</div>
<?php
/**
 * @var $data News
 * @var $thumbnailUrl string Thumbnail Image URL
 */
?>
<div class="news-item">
    <?php
    if ($thumbnailUrl = News::model()->findByPk($data->id)->getThumbnailUrl()) {
        echo CHtml::link(CHtml::image($thumbnailUrl, $data->title), array('default/show', 'slug' => $data->slug));
    }
    ?>
    <h2><?php echo CHtml::link($data->title, array('default/show', 'slug' => $data->slug));?></h2>
    <span class="label"><?php echo $data->date;?></span>
    <?php echo $data->content_short;?>
</div>
<div style="clear: both">&nbsp;</div>
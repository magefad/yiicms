<?php
/**
 * @var $data News
 * @var $thumbnailUrl string Thumbnail Image URL
 */
?>
<div class="span12 news-item">
    <?php
    if ($thumbnailUrl = News::model()->findByPk($data->id)->getThumbnailUrl()) {
        echo CHtml::link(
            CHtml::image($thumbnailUrl, $data->title),
            array('default/show', 'slug' => $data->slug)
        );
    }
    ?>
    <h5><?php echo CHtml::link($data->title, array('default/show', 'slug' => $data->slug));?></h5>
    <span class="label"><?php echo $data->date;?></span>
    <?php echo $data->content_short;?>
</div>
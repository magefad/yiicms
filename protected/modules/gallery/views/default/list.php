<?php
/**
 * User: fad
 * Date: 07.08.12
 * Time: 16:10
 *
 * @var $albums Photo[]
 */
$this->pageTitle = Yii::app()->name . ' — ' . Yii::t('GalleryModule.gallery', 'Gallery');
?>
<h2><?php echo Yii::t('GalleryModule.gallery', 'Albums'); ?></h2>
<ul class="unstyled">
    <?php foreach ($albums as $album): ?>
    <li><?php echo CHtml::link($album->title . ' »', array('/album/' . $album->slug));?></li>
    <?php endforeach;?>
</ul>
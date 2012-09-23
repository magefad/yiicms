<?php
/** @var $news News */
?>
<div class='portlet'>
    <div class='portlet-decoration'>
        <div class='portlet-title'>Новости</div>
    </div>
    <div class='portlet-content'>
        <ul class="unstyled">
            <?php foreach ($news as $new): ?>
            <li><?php echo CHtml::link($new->title . ' »', array('/news/default/show', 'slug' => $new->slug));?></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>

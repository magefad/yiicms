<?php
/**
 * @var $news News
 * @var $new News
 */
?>
<div class='portlet'>
    <div class='portlet-content'>
        <ul class="unstyled">
            <?php foreach ($news as $new): ?>
                <li>
                    <small class="text-success"><?php echo $new->date; ?></small><br />
                    <?php echo CHtml::link($new->title, array('/news/default/show', 'slug' => $new->slug));?>
                    <?php echo $new->content_short; ?>
                </li>
            <?php endforeach;?>
        </ul>
        <?php echo CHtml::link('Все новости', array('/news'), array('class' => 'pull-right')); ?>
    </div>
</div>

<?php
/**
 * @var Page $data
 * @var int $index
 */
if (!($index % 3)):
    if($index):?>
    </ul>
    <?php endif; ?>
    <ul class="thumbnails" id="articles">
<?php endif;?>
        <li class="span4">
            <div class="thumbnail">
                <?= CHtml::link(CHtml::image($data->getThumbnailUrl(), $data->name), array('/page/default/show', 'slug' => $data->slug)) ?>
                <div class="caption">
                    <h3><?= CHtml::link($data->name, array('/page/default/show', 'slug' => $data->slug)) ?></h3>
                    <div class="date"><?= Yii::app()->dateFormatter->formatDateTime($data->create_time, 'long', 'short'); ?></div>
                    <p><?= $data->annotation ?></p>
                    <?= CHtml::link(Yii::t('PageModule.page', 'Full article') . ' <i class="icon-circle-arrow-right"></i>', array('/page/default/show', 'slug' => $data->slug), array('class' => 'btn btn-mini')) ?>
                </div>
            </div>
        </li>

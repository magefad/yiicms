<?php /** @var Page $data */
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
                    <h3><?= $data->name ?></h3>
                    <small><?= Yii::app()->dateFormatter->formatDateTime($data->create_time, 'long', 'short'); ?></small>
                    <p><?= $data->annotation ?></p>
                    <?= CHtml::link(Yii::t('PageModule.page', 'Continue reading') . '<i class="icon-circle-arrow-right"></i>', array('/page/default/show', 'slug' => $data->slug), array('class' => 'btn btn-mini')) ?>
                </div>
            </div>
        </li>

<?php
/**
 * @var CatalogItem $data
 * @var $this Controller
 * @var $index int
 */
if (!($index % 3)):
    if($index):?>
    </ul>
    <?php endif; ?>
    <hr />
    <ul class="thumbnails" id="catalog">
<?php endif;?>
    <li class="span4">
        <a href="<?= $this->createAbsoluteUrl('/catalog/catalogItem/show', array('slug' => $data->slug)) ?>" class="photo styler_parent">
            <span class="img"><img src="<?= $data->getValue('thumbnail') ?>" alt="<?= $data->getValue('title') ?>" /></span>
            <span class="text styler_hover_border_color">
                <i class="styler_border_color"></i>
                <!-- team member name -->
                <span class="name"><?= $data->getValue('fio') ?></span>
                <!-- team member title -->
                <span class="desc" style="line-height: 13px">
                    <?= $data->getValue('fio_type') ?>,<br />
                    <small><?= $data->getValue('what') ?><br />
                        <?= $data->getValue('where') ?></small>
                </span>
            </span>
        </a>
    </li>

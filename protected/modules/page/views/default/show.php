<?php
/**
 * User: fad
 * Date: 16.07.12
 * Time: 17:14
 * @var $this Controller
 */
/** @var $page array */
echo $this->decodeWidgets($page['content']);
if (!empty($navigation)):?>
<ul class="pager">
<?php if (isset($navigation['prev'])):?>
    <li class="previous">
        <?php echo CHtml::link('&larr; ' . $navigation['prev']['name'], array('/page/default/show', 'slug' => $navigation['prev']['slug']));?>
    </li>
<?php endif;?>
<?php if (isset($navigation['next'])):?>
    <li class="next">
        <?php echo CHtml::link($navigation['next']['name'] . ' &rarr;',  array('/page/default/show', 'slug' => $navigation['next']['slug']));?>
    </li>
<?php endif;?>
</ul>
<?php endif;?>
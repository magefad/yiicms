<?php
/**
 * User: fad
 * Date: 16.07.12
 * Time: 17:14
 * @var $this Controller
 */
/** @var $page Page */
echo $this->decodeWidgets($page->content);
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
<?php endif;
if (!is_null($page->type) && $page->type == Page::TYPE_CATALOG && Yii::app()->hasModule('catalog')) {
    Yii::import('catalog.models.Good');//@todo why not found?
    foreach ($page->goods as $good) {
        $this->renderPartial('application.modules.catalog.views.good.' . Yii::app()->getModule('catalog')->template, array('good' => $good));
    }
}

<?php
/**
 * User: fad
 * Date: 16.07.12
 * Time: 17:14
 * @var $this Controller
 * @var $page Page
 */
echo $this->decodeWidgets($page->content);
if (Yii::app()->hasModule('catalog')) {
    if (!is_null($page->type) && $page->type == Page::TYPE_CATALOG) {
        Yii::import('catalog.models.Good');//@todo why not found?
        foreach ($page->goods as $good) {
            $this->renderPartial('application.modules.catalog.views.good.' . Yii::app()->getModule('catalog')->template, array('good' => $good));
        }
    } else {
        echo CHtml::tag('ul', array('class' => 'nav nav-tabs nav-stacked'));
        foreach ($page->children as $children) {
            if (!is_null($children->type) && $children->type == Page::TYPE_CATALOG) {
                echo '<li>' . CHtml::link($children->title, array('/page/default/show', 'slug' => $children->slug)) . '</li>';
            }
        }
        echo CHtml::closeTag('ul');
    }
}
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

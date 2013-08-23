<?php
/**
 * @var $this Controller
 * @var $good Good
 */
$css = <<<CSS
    .bg {
        background-color: #6c7480; color: white;
    }
    .good .header .big {
        font-size: 200%;
        font-weight: 600;
    }
    .good .header {
        padding-top: 8px;
        padding-bottom: 4px;
    }

    .good .footer a {
        color: white;
    }
CSS;
Yii::app()->clientScript->registerCss(__FILE__, $css);
//@todo duplicated styles see _item.php
$this->breadcrumbs = array(
    $good->page->title => array('/page/default/show', 'slug' => $good->page->slug),
	$good->name,
);
?>
<div class="good" style="background-color: white; border: 2px solid #e4e4e4; border-radius: 5px; padding: 10px">
    <div class="row-fluid">
        <h1 style="margin: 5px 0"><?=$good->title?></h1>
        <?=GoodTemplate::getName('city') . ' ' . $good->getValue('city') ?>
    </div>
    <div>&nbsp;</div>
    <div class="row-fluid">
        <div class="header span2 offset3 text-center bg">
            <?=GoodTemplate::getName('id')?> <span class="big"><?=$good->getValue('id')?></span>
        </div>
    </div>
    <div class="row-fluid">
        <span class='span3'>
            <img src="<?=$good->getValue('photo')?>" alt="<?=$good->name?>" />
        </span>
        <div class="span9" style="font-weight: 600; padding-left: 10px; background-color: #f9f9f9; color: #354050">
            <div class="row-fluid" style="font-size: 17px; font-weight: bold; margin: 10px 0 15px 0;">
                <div class="span4"><?=GoodTemplate::getName('perfomance') ?> - <?=$good->getValue('perfomance') ?> ед.ч</div>
                <div class="span4"><?=GoodTemplate::getName('area') ?> - <?=$good->getValue('area') ?> м<sup>2</sup></div>
                <div class="span4"><?=GoodTemplate::getName('height') ?> - <?=$good->getValue('height') ?> м</div>
            </div>
            <p><?=$good->getValue('description') ?></p>
        </div>
    </div>
</div>
<div>&nbsp;</div>
<div class="row-fluid">
<?php
$this->widget(
    'bootstrap.widgets.TbTabs',
    array(
        'htmlOptions' => array('class' => 'span8'),
        'tabMenuHtmlOptions' => array('style' => 'margin-bottom: 0'),
        'tabContentHtmlOptions' => array('style' => 'padding: 15px; border-left: 1px solid #ddd;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;'),
        'tabs' => array(
            array(
                'label'   => GoodTemplate::getName('plotMapText'),
                'content' => CHtml::image(
                    $good->getValue('plotMapImg'),
                    GoodTemplate::getName('plotMapText'),
                    array('class' => 'pull-right')
                ) . '<ol><li>' . str_replace(array("\r","\n\n","\n"), array('',"\n","</li>\n<li>"), $good->getValue('plotMapText')) . '</li></ol>',
                'active'  => true
            ),
            array(
                'label'   => GoodTemplate::getName('layoutDiagramDescription'),
                'content' => $good->getValue('layoutDiagramDescription')
            ),
        ),
    )
);
echo '</div><div>&nbsp;</div>';
echo CHtml::tag('h2', array('clearfix'), 'Другие проекты раздела «' . $good->page->title . '»');
foreach ($good->page->goods as $good) {
    $this->renderPartial(
        'application.modules.catalog.views.good.' . $this->getModule()->template,
        array('good' => $good)
    );
}

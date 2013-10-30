<?php
/**
 * @var $this Controller
 * @var $catalogItem CatalogItem
 */

//@todo duplicated styles see _item.php
$this->breadcrumbs = array(
    $catalogItem->page->title => array('/page/default/show', 'slug' => $catalogItem->page->slug),
	$catalogItem->name,
);
echo $catalogItem->getValue('text');
echo CHtml::tag('h2', array('clearfix'), 'Другие ' . $catalogItem->page->title);
/*$this->widget(
    'zii.widgets.CListView',
    array(
        'dataProvider' => new CActiveDataProvider('CatalogItem', array(
                'data' => $catalogItem->page->catalogItems,
            )),
        'itemView'     => 'application.modules.catalog.views.catalogItem.' . $this->getModule()->template,
        'template'     => '{sorter}{items}{pager}',
        'htmlOptions'  => array('style' => 'padding-top:0'),
    )
);*/

echo '</ul></div><div>&nbsp;</div>';

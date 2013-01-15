<?php
/**
 * @var $this Controller
 * @var $model Blog
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs')
);

$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider'       => $dataProvider,
        'itemView'           => '_listView',
        'sortableAttributes' => array(
            'title',
            'update_time',
        ),
        'htmlOptions'        => array('style' => 'padding-top:0'),
        'template'           => '{items}{pager}{summary}{sorter}',
    )
);

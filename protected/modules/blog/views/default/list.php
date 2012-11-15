<?php
/**
 * @var $this Controller
 * @var $model Blog
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs')
);

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Blogs')),
    array('icon'  => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('BlogModule.blog', 'Create'), 'url' => array('create')),
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

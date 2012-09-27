<?php
/**
 * @var $this Controller
 * @var $model Blog
 */
$this->breadcrumbs = array(
    Yii::t('blog', 'Blogs')
);

$this->menu = array(
    array('label' => Yii::t('blog', 'Blogs')),
    array('icon'  => 'list-alt', 'label' => Yii::t('blog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('blog', 'Create'), 'url' => array('create')),
);

$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider'       => $dataProvider,
        'itemView'           => '_view',
        'sortableAttributes' => array(
            'title',
            'update_time',
        ),
        'htmlOptions'        => array('style' => 'padding-top:0'),
        'template'           => '{items}{pager}{summary}{sorter}',
    )
);

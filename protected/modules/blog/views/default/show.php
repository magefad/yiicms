<?php
/**
 * User: fad
 * Date: 25.09.12
 * Time: 15:18
 * @var $this Controller
 * @var $blog Blog
 * @var $postsDataProvider CActiveDataProvider
 */
$this->pageTitle   = Yii::app()->name . ' — ' . Yii::t('BlogModule.blog', 'Blog');
$tagBreadcrumb     = isset($tag) ? Yii::t('BlogModule.blog', 'Tagged') . ' «' . $tag . '»' : Yii::t('BlogModule.blog', 'All posts');
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('/blog/default/index'),
    $tagBreadcrumb
);
$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider'       => $postsDataProvider,
        'enableHistory'      => true,
        'itemView'           => 'blog.views.default._show',
        'sortableAttributes' => array(
            'title',
            'publish_time',
        ),
        'htmlOptions'        => array('style' => 'padding-top:0'),
        'template'           => '{items}{pager}{summary}{sorter}',
    )
);

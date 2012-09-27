<?php

/**
 * @var $this Controller
 * @var $model Post
 */
$this->breadcrumbs = array(
    Yii::t('blog', 'Posts') => array('admin'),
    Yii::t('blog', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('blog', 'Blogs')),
    array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Manage'), 'url' => array('/blog/default/admin')),
    array('icon' => 'file', 'label' => Yii::t('blog', 'Create'), 'url' => array('create')),
    array('label' => Yii::t('blog', 'Posts')),
    array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Manage'), 'url' => array('/blog/post/admin')),
    array('icon' => 'file', 'label' => Yii::t('blog', 'Create'), 'url' => array('post/create')),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('post-grid', {
        data: $(this).serialize()
    });
    return false;
});
"
);
?>
<?php echo CHtml::link(Yii::t('blog', 'Search'), '#', array('class'=> 'search-button btn btn-small')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget(
    'CustomTbGridView',
    array(
        'id'                    => 'post-grid',
        'type'                  => 'striped condensed',
        'dataProvider'          => $model->search(),
        'filter'                => $model,
        'rowCssClassExpression' => '($data->status == 2) ? "error" : (($data->status) ? "published" : "warning")',
        'columns'               => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width: 20px; text-align: center'),
            ),
            array(
                'name'  => 'title',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->title, array("/blog/post/update/", "id" => $data->id))',
            ),
            array(
                'name'  => 'slug',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->slug, array("show", "slug" => $data->slug), array("target" => "_blank"))',
            ),
            array(
                'name'  => 'blog_id',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->blog->title, array("/blog/default/show", "slug" => $data->blog->slug), array("target" => "_blank"))',
            ),
            array(
                'name'  => 'create_user_id',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->createUser->username, array("/user/default/view/", "id" => $data->createUser->id))',
            ),
            array(
                'name'  => 'update_user_id',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->updateUser->username, array("/user/default/view/", "id" => $data->updateUser->id))',
            ),
            array(
                'name'  => 'publish_time',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->publish_time, "short", "short")',
            ),
            array(
                'name'  => 'create_time',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_time, "short", "short")',
            ),
            array(
                'name'  => 'update_time',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->update_time, "short", "short")',
            ),
            array(
                'name'  => 'status',
                'type'  => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data)',
                'htmlOptions' => array('style' => 'width: 20px; text-align: center'),
            ),
            //'content',
            //'keywords',
            //'description',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>

<?php
/**
 * @var $this Controller
 * @var $model Blog
 */
$this->breadcrumbs = array(
    Yii::t('blog', 'Blogs') => array('admin'),
    Yii::t('blog', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('blog', 'Blogs')),
    array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Manage'), 'url' => array('/blog/default/admin')),
    array('icon' => 'file', 'label' => Yii::t('blog', 'Create'), 'url' => array('create')),
    array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Manage Posts'), 'url' => array('post/admin')),
    array('icon' => 'file', 'label' => Yii::t('blog', 'Create Post'), 'url' => array('post/create')),
    array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Manage Users'), 'url' => array('userBlog/admin')),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('blog-grid', {
		data: $(this).serialize()
	});
	return false;
});
"
);
?>
<?php echo CHtml::link(Yii::t('blog', 'Search'), '#', array('class' => 'search-button btn btn-small')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget(
    'CustomTbGridView',
    array(
        'id'                    => 'blog-grid',
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
                'value' => 'CHtml::link($data->title, array("update", "id" => $data->id))',
            ),
            array(
                'header'  => Yii::t('blog', 'Posts'),
                'value'   => '$data->postsCount',
            ),
            array(
                'header'  => Yii::t('blog', 'Members'),
                'value'   => '$data->membersCount',
            ),
            array(
                'name'  => 'slug',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->slug, array("show", "slug" => $data->slug), array("target" => "_blank"))',
            ),
            array(
                'name'        => 'type',
                'value'       => '$data->getType()',
                'htmlOptions' => array('style' => 'width: 60px; text-align: center;'),
            ),
            array(
                'name'        => 'create_time',
                'value'       => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_time, "short", "short")',
                'htmlOptions' => array('style' => 'width: 100px; text-align: center;'),
            ),
            array(
                'name'        => 'update_time',
                'value'       => 'Yii::app()->getDateFormatter()->formatDateTime($data->update_time, "short", "short")',
                'htmlOptions' => array('style' => 'width: 100px; text-align: center;'),
            ),
            array(
                'name'        => 'create_user_id',
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->createUser->username, array("/user/default/view/", "id" => $data->createUser->id))',
                'htmlOptions' => array('style' => 'width: 60px; text-align: center;'),
            ),
            array(
                'name'        => 'update_user_id',
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->updateUser->username, array("/user/default/view/", "id" => $data->updateUser->id))',
                'htmlOptions' => array('style' => 'width: 60px; text-align: center;'),
            ),
            array(
                'name'        => 'status',
                'type'        => 'raw',
                'value'       => '$this->grid->returnBootstrapStatusHtml($data)',
                'filter'      => array(
                    '' => Yii::t('blog', 'All'),
                    1  => Yii::t('blog', 'Public'),
                    0  => Yii::t('blog', 'Draft'),
                    2  => Yii::t('blog', 'On moderation')
                ),
                'htmlOptions' => array('style' => 'width: 40px; text-align: center;'),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>

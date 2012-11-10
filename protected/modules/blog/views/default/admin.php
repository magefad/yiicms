<?php
/**
 * @var $this Controller
 * @var $model Blog
 */
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('admin'),
    Yii::t('BlogModule.blog', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Blogs')),
    array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage'), 'url' => array('/blog/default/admin')),
    array('icon' => 'file', 'label' => Yii::t('BlogModule.blog', 'Create'), 'url' => array('create')),
    array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage Posts'), 'url' => array('post/admin')),
    array('icon' => 'file', 'label' => Yii::t('BlogModule.blog', 'Create Post'), 'url' => array('post/create')),
    array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage Users'), 'url' => array('userBlog/admin')),
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
<?php echo CHtml::link(Yii::t('BlogModule.blog', 'Search'), '#', array('class' => 'search-button btn btn-small')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget(
    'FadTbGridView',
    array(
        'id'           => 'blog-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
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
                'header'  => Yii::t('BlogModule.blog', 'Posts'),
                'value'   => '$data->postsCount',
            ),
            array(
                'header'  => Yii::t('BlogModule.blog', 'Members'),
                'value'   => '$data->membersCount',
            ),
            array(
                'name'  => 'slug',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->slug, array("show", "slug" => $data->slug), array("target" => "_blank"))',
            ),
            array(
                'name'        => 'type',
                'value'       => '$data->statusType->getText()',
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
                'value'       => '$this->grid->getStatus($data)',
                'filter'      => $model->statusMain->getList(),
                'htmlOptions' => array('style' => 'width: 40px; text-align: center;'),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>

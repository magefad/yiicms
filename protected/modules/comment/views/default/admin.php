<?php
/**
 * @var $this Controller
 * @var $model Comment
 */

$this->breadcrumbs = array(
	Yii::t('CommentModule.comment', 'Comments') => array('admin'),
	Yii::t('CommentModule.comment', 'Manage')
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('comment-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<?php echo CHtml::link(Yii::t('CommentModule.comment', 'Search'),'#',array('class'=>'search-button btn btn-small')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
    'id'           => 'comment-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
		'id',
		'model',
		'model_id',
        'create_user_id',
        'update_user_id',
		'create_time',
		'update_time',
		/*
		'content',
		'status',
		'ip',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

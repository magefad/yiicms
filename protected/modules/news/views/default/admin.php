<?php
/**
 * @var $model News
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('news', 'Новости') => array('admin'),
    Yii::t('news', 'Управление'),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('news-grid', {
		data: $(this).serialize()
	});
	return false;
});
"
);
?>
<?php echo CHtml::link(
    Yii::t('News', '<i class="icon-search"></i> Поиск <span class="caret"></span>'),
    '#',
    array('class' => 'search-button btn btn-small')
) ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php
$this->widget(
    'FadTbGridView',
    array(
        'id'           => 'news-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width:20px'),
            ),
            array(
                'name'        => 'date',
                'htmlOptions' => array('style' => 'width:80px'),
            ),
            array(
                'name'  => 'title',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->title,array("update", "id" => $data->id))'
            ),
            array(
                'name'  => 'slug',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->slug, array("show", "slug" => $data->slug))',
            ),
            'create_time',
            'update_time',
            array(
                'name'        => 'author_search',
                'value'       => '$data->author->username',
                'htmlOptions' => array('style' => 'width:40px; text-align:center;'),
            ),
            array(
                'name'        => 'status',
                'type'        => 'raw',
                'value'       => '$this->grid->getStatus($data)',
                'filter'      => array(
                    '' => Yii::t('menu', 'Все'),
                    1  => Yii::t('menu', 'Опубликовано'),
                    0  => Yii::t('menu', 'Черновики'),
                    2  => Yii::t('menu', 'На модерации')
                ),
                'htmlOptions' => array('style' => 'width:40px; text-align:center;'),
            ), /*'create_time',
		'update_time',
		'date',
		'title',
		'slug',
		'content_short',
		'content',
		'create_user_id',
		'status',
		'is_protected',
		'keywords',
		'description',
		*/
            array(
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width:60px; text-align: center;')
            ),
        ),
    )
); ?>

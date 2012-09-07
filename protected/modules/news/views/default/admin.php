<?php
/** @var $model News */
$this->breadcrumbs = array(
	Yii::t('news', 'Новости') => array('admin'),
	Yii::t('news', 'Управление'),
);

$this->menu = array(
	array('label' => Yii::t('news', 'Новости')),
	array('icon' => 'list-alt white', 'label' => Yii::t('news', 'Управление'), 'url' => array('/news/default/admin')),
	array('icon' => 'th-list', 'label' => Yii::t('news', 'Показать анонсами'), 'url' => array('index')),
	array('icon' => 'file', 'label' => Yii::t('news', 'Создать'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
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
");
?>
<!-- <h1><?php echo Yii::t('News', 'Управление')?> News</h1> -->
<?php echo CHtml::link(Yii::t('News', '<i class="icon-search"></i> Поиск <span class="caret"></span>'), '#', array('class' => 'search-button btn btn-small')) ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php
$this->widget('CustomTbGridView', array(
	'id'                    => 'news-grid',
	'type'                  => 'striped condensed',
	'dataProvider'          => $model->search(),
	'filter'                => $model,
	'rowCssClassExpression' => '($data->status == 2) ? "moderation" : (($data->status) ? "published" : "draft")',
	'columns'               => array(
		array(
			'name' => 'id', 'htmlOptions' => array('style'=> 'width:20px'),
		), array(
			'name' => 'date', 'htmlOptions' => array('style'=> 'width:80px'),
		), array(
			'name'  => 'title',
			'type'  => 'raw',
			'value' => 'CHtml::link($data->title,array("/news/update","id" => $data->id))'
		), array(
			'name'  => 'slug',
			'type'  => 'raw',
			'value' => 'CHtml::link($data->slug, array("show", "slug" => $data->slug))',
		), 'creation_date', 'change_date', array(
			'name'        => 'author_search',
			'value'       => '$data->author->username',
			'htmlOptions' => array('style'=> 'width:40px; text-align:center;'),
		), array(
			'name'        => 'status',
			'type'        => 'raw',
			'value'       => '$this->grid->returnBootstrapStatusHtml($data)',
			'filter'      => array(
				'' => Yii::t('menu', 'Все'),
				1  => Yii::t('menu', 'Опубликовано'),
				0  => Yii::t('menu', 'Черновики'),
				2  => Yii::t('menu', 'На модерации')
			),
			'htmlOptions' => array('style'=> 'width:40px; text-align:center;'),
		), /*'creation_date',
		'change_date',
		'date',
		'title',
		'slug',
		'body_cut',
		'body',
		'user_id',
		'status',
		'is_protected',
		'keywords',
		'description',
		*/
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

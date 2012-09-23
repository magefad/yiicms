<?php
/**
 * @var $model Photo
 * @var $form TbActiveForm
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('gallery', 'Фотографии') => array('index'),
    Yii::t('gallery', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('gallery', 'Список'), 'url' => array('index')),
    array('label' => Yii::t('gallery', 'Добавить'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('photo-grid', {
		data: $(this).serialize()
	});
	return false;
});
"
);
?>
<?php echo CHtml::link(
    Yii::t('Фотографии', '<i class="icon-search"></i> Поиск <span class="caret"></span>'),
    '#',
    array('class' => 'search-button btn btn-small')
) ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget(
    'CustomTbGridView',
    array(
        'id'                    => 'photo-grid',
        'type'                  => 'striped condensed',
        'dataProvider'          => $model->search(),
        'filter'                => $model,
        'rowCssClassExpression' => '($data->status == 2) ? "moderation" : (($data->status) ? "published" : "draft")',
        'columns'               => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width: 20px; text-align: center'),
            ),
            array(
                'name'  => 'gallery_search',
                'value' => '$data->gallery->name',
                #'htmlOptions' => array('style' => 'width: 60px;text-align: center;'),
            ),
            'name',
            array(
                'name'        => 'author_search',
                'value'       => '$data->author->username',
                'htmlOptions' => array('style' => 'width: 60px;text-align: center;'),
            ),
            array(
                'name'        => 'changeAuthor_search',
                'value'       => '$data->changeAuthor->username',
                'htmlOptions' => array('style' => 'width: 60px;text-align: center;'),
            ),
            array(
                'name'        => 'status',
                'type'        => 'raw',
                'value'       => '$this->grid->returnBootstrapStatusHtml($data)',
                'filter'      => array(
                    '' => Yii::t('menu', 'Все'),
                    1  => Yii::t('menu', 'Опубликовано'),
                    0  => Yii::t('menu', 'Скрыто')
                ),
                'htmlOptions' => array('style' => 'width:40px; text-align:center;'),
            ), /*'title',
		'description',
		'keywords',
		'file_name',
		'creation_date',
		'change_date',
		'user_id',
		'change_user_id',
		'alt',
		'type',
		'status',
		'sort',
		*/
            array(
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width:60px; text-align: center;')
            ),
        ),
    )
); ?>

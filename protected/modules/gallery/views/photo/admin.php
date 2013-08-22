<?php
/**
 * @var $model Photo
 * @var $form TbActiveForm
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('GalleryModule.gallery', 'Photos') => array('index'),
    Yii::t('GalleryModule.gallery', 'Manage'),
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
    Yii::t('GalleryModule.gallery', '<i class="icon-search"></i> Search <span class="caret"></span>'),
    '#',
    array('class' => 'search-button btn btn-small')
) ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget(
    'bootstrap.widgets.TbExtendedGridView',
    array(
        'id'           => 'photo-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width: 20px; text-align: center'),
            ),
            array(
                'name'  => 'gallery_search',
                'value' => '$data->gallery->title',
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
                'value'       => 'isset($data->changeAuthor->username) ? $data->changeAuthor->username : "-"',
                'htmlOptions' => array('style' => 'width: 60px;text-align: center;'),
            ),
            array(
                'class'                => 'bootstrap.widgets.TbToggleColumn',
                'checkedButtonLabel'   => Yii::t('GalleryModule.gallery', 'Published. Hide?'),
                'uncheckedButtonLabel' => Yii::t('GalleryModule.gallery', 'Hidden. Publish?'),
                'name'                 => 'status',
                'filter'      => array(
                    0  => Yii::t('GalleryModule.gallery', 'Hidden'),
                    1  => Yii::t('GalleryModule.gallery', 'Published')
                ),
                'htmlOptions' => array('style' => 'width:40px; text-align:center;'),
            ), /*'title',
		'description',
		'keywords',
		'file_name',
		'create_time',
		'update_time',
		'create_user_id',
		'update_user_id',
		'alt',
		'type',
		'status',
		'sort_order',
		*/
            array(
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width:60px; text-align: center;')
            ),
        ),
    )
); ?>

<?php
/**
 * @var $model Gallery
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('GalleryModule.gallery', 'Gallery') => array('admin'),
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
	$.fn.yiiGridView.update('gallery-grid', {
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
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget(
    'FadTbGridView',
    array(
        'id'           => 'gallery-grid',
        #'sortableRows' => true,
        #'sortableAjaxSave' => true,
        #'sortableAction' => 'menu/default/sortable',
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
                'value' => 'CHtml::link($data->title, array("update", "id" => $data->id))'
            ),
            #'description',
            #'keywords',
            array(
                'name'  => 'slug',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->slug, array("/album/$data->slug"))',
            ),
            /*array(
                'name'        => 'sort_order',
                'type'        => 'raw',
                'value'       => '$this->grid->getUpDownButtons($data)',
                'htmlOptions' => array('style' => 'width: 30px; text-align: center'),
            ),*/
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
            ),
            array(
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'template'    => '{view} {update} {delete} {manager}',
                'buttons'     => array(
                    'manager' => array(
                        'label'   => false,
                        'url'     => 'array("photo/manager", "id" => $data->id)',
                        'options' => array('class' => 'icon-picture', 'title' => Yii::t('galleryModule.gallery', 'Photos')),
                    ),
                ),
                'htmlOptions' => array('style' => 'width: 85px'),
            ),
        ),
    )
); ?>

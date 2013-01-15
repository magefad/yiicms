<?php
/**
 * @var $model Gallery
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('gallery', 'Галерея') => array('admin'),
    Yii::t('gallery', 'Управление'),
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
    Yii::t('gallery', '<i class="icon-search"></i> Поиск <span class="caret"></span>'),
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
                'checkedButtonLabel'   => Yii::t('global', 'Опубликовано. Скрыть?'),
                'uncheckedButtonLabel' => Yii::t('global', 'Скрыто. Опубликовтаь?'),
                'name'                 => 'status',
                'filter'      => array(
                    0  => Yii::t('menu', 'Скрыто'),
                    1  => Yii::t('menu', 'Опубликовано')
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
                        'options' => array('class' => 'icon-picture', 'title' => 'Фотографии'),
                    ),
                ),
                'htmlOptions' => array('style' => 'width: 85px'),
            ),
        ),
    )
); ?>

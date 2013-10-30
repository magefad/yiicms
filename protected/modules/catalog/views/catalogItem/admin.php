<?php
/**
 * @var $this Controller
 * @var $model CatalogItem
 */
$this->breadcrumbs = array(
	Yii::t('CatalogModule.catalog', 'Items') => array('admin'),
	Yii::t('CatalogModule.catalog', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('CatalogModule.catalog', 'Items')),
    array('icon' => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Manage'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('CatalogModule.catalog', 'Create'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('catalogItem-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<?php //echo CHtml::link(Yii::t('CatalogModule.catalog', 'Search'), '#', array('class' => 'search-button btn btn-small')); ?>
<?php echo CHtml::link(Yii::t('CatalogModule.catalog', 'Item Templates'), array('/catalog/catalogItemTemplate'), array('class' => 'btn btn-small')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget('FadTbGridView', array(
    'id'           => 'catalogItem-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
		//'id',
        array(
            'name'  => 'page_id',
            'value' => 'CHtml::link($data->page->name, array("/page/default/update", "id" => $data->page->id), array("target" => "_blank"))',
            'type'  => 'raw'
        ),
		'name',
		'title',
        array(
            'name' => 'slug',
            'value' => 'CHtml::link($data->slug, array("/catalog/catalogItem/show", "slug" => $data->slug), array("target" => "_blank"))',
            'type' => 'raw'
        ),
        array(
            'name'        => 'create_time',
            'value'       => 'date_format(date_create($data->create_time), "d.m.Y")',
            'htmlOptions' => array('style' => 'width:80px; text-align:center;'),
        ),
        array(
            'name'        => 'update_time',
            'value'       => 'date_format(date_create($data->update_time), "d.m.Y")',
            'htmlOptions' => array('style' => 'width:80px; text-align:center;'),
        ),
        /*'keywords',
        'description',

        'slug',
        'status',
        'create_user_id',
        'update_user_id',
        'create_time',
        'update_time',
        */
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<?php

/**
 * @var $this Controller
 * @var $model CatalogItemTemplate
 */
$this->breadcrumbs = array(
	Yii::t('CatalogModule.catalog', 'Item Templates') => array('admin'),
	Yii::t('CatalogModule.catalog', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('CatalogModule.catalog', 'Item Templates')),
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
    $.fn.yiiGridView.update('catalogItem-template-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<?php //echo CHtml::link(Yii::t('CatalogModule.catalog', 'Search'), '#', array('class' => 'search-button btn btn-small')); ?>
<?php echo CHtml::link(Yii::t('CatalogModule.catalog', 'Items'), array('/catalog/catalogItem'), array('class' => 'btn btn-small')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget(
    'FadTbGridView',
    array(
        'id'                    => 'catalogItem-template-grid',
        'dataProvider'          => $model->search(),
        'rowCssClassExpression' => '',
        'filter'                => $model,
        'columns'               => array(
            'key',
            'name',
            array(
                'name'  => 'input_type',
                'value' => '$data->statusInputType->getText($data->input_type)'
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>

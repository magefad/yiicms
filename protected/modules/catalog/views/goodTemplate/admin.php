<?php

/**
 * @var $this Controller
 * @var $model GoodTemplate
 */
$this->breadcrumbs = array(
	Yii::t('CatalogModule.catalog', 'Good Templates') => array('admin'),
	Yii::t('CatalogModule.catalog', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('CatalogModule.catalog', 'Good Templates')),
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
    $.fn.yiiGridView.update('good-template-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<?php //echo CHtml::link(Yii::t('CatalogModule.catalog', 'Search'), '#', array('class' => 'search-button btn btn-small')); ?>
<?php echo CHtml::link(Yii::t('CatalogModule.catalog', 'Goods'), array('/catalog/good'), array('class' => 'btn btn-small')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget(
    'FadTbGridView',
    array(
        'id'                    => 'good-template-grid',
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

<?php
/**
 * @var $model Menu
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню')        => array('default/admin'),
    Yii::t('menu', 'Управление'),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('menu-grid', {
		data: $(this).serialize()
	});
	return false;
});
"
);
echo CHtml::link(
    Yii::t('page', '<i class="icon-search"></i> Поиск меню <span class="caret"></span>'),
    '#',
    array('class' => 'search-button btn btn-small')
) ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget(
    //'bootstrap.widgets.TbExtendedGridView',
    'ext.grid.TbTreeGridView',
    array(
        'id'                    => 'menu-grid',
        'type'                  => 'condensed',
        'dataProvider'          => $model->search(),
        //'ajaxUpdate' => false,
        'rowCssClassExpression' => '$data->status ? "published" : "error"',
        'columns'               => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width: 20px; text-align: center'),
            ),
            'title',
            array(
                'name' => 'href',
                'value' => '$data->href ? $data->href : "Menu::model()->getItems(\'".$data->code."\')"',
            ),
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
            'access',
            'update_time',
            array(
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width:60px; text-align: center;')
            ),
        ),
    )
); ?>

<?php
/**
 * @var $model Item
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню')        => array('default/admin'),
    Yii::t('menu', 'Пункты меню') => array('admin'),
    Yii::t('menu', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('menu', 'Меню')),
    array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('default/admin')),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('default/create')),
    array('label' => Yii::t('menu', 'Пункты меню')),
    array('icon' => 'list-alt white', 'label' => Yii::t('menu', 'Управление'), 'url' => array('/menu/item/admin')),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('item/create')),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('item-grid', {
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
    'CustomTbGridView',
    array(
        'id'                    => 'item-grid',
        'type'                  => 'striped condensed',
        'dataProvider'          => $model->search(),
        'filter'                => $model,
        'rowCssClassExpression' => '($data->status == 2) ? "error" : (($data->status) ? "published" : "warning")',
        'columns'               => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width: 20px; text-align: center'),
            ),
            'title',
            'href', /*array(
			'name' => 'menu_id',
			'value' => '$data->menu->name',
			'filter' => array_merge(array('' => Yii::t('menu', 'Все')), CHtml::listData(Menu::model()->findAll(array('order' =>'name')), 'id', 'name')),
		),*/
            array(
                'name'  => 'menu_search',
                'value' => '$data->menu->name',
            ),
            array(
                'name' => 'parent_search',
            ),
            array(
                'name'        => 'sort',
                'type'        => 'raw',
                'value'       => '$this->grid->getUpDownButtons($data)',
                'htmlOptions' => array('style' => 'width: 30px; text-align: center'),
            ),
            array(
                'name'        => 'status',
                'type'        => 'raw',
                'value'       => '$this->grid->returnBootstrapStatusHtml($data)',
                'filter'      => array(
                    ''  => Yii::t('menu', 'Все'),
                    '1' => Yii::t('menu', 'Включено'),
                    0   => Yii::t('menu', 'Выключено')
                ),
                'htmlOptions' => array('style' => 'width:40px; text-align:center;'),
            ), #'type',
            'access',
            array(
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width:60px; text-align: center;')
            ),
        ),
    )
); ?>

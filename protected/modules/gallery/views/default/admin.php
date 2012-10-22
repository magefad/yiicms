<?php
/**
 * @var $model Gallery
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('gallery', 'Галерея') => array('admin'),
    Yii::t('gallery', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('gallery', 'Галерея')),
    array(
        'icon'  => 'list-alt white',
        'label' => Yii::t('page', 'Управление'),
        'url'   => array('/gallery/default/admin')
    ),
    array('icon' => 'file', 'label' => Yii::t('page', 'Добавить'), 'url' => array('create')),
    array('icon' => 'file', 'label' => Yii::t('page', 'Настройки'), 'url' => array('/admin/setting/update/gallery')),

    #array('label' => Yii::t('page', 'Фотографии')),
    #array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление'), 'url' => array('/photo/manager')),
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
    'CustomTbGridView',
    array(
        'id'                    => 'gallery-grid',
        'type'                  => 'striped condensed',
        'dataProvider'          => $model->search(),
        'enableHistory'         => true,
        'filter'                => $model,
        'rowCssClassExpression' => '($data->status == 2) ? "error" : (($data->status) ? "published" : "warning")',
        'columns'               => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width: 20px; text-align: center'),
            ),
            array(
                'name'  => 'name',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->name,array("update", "id" => $data->id))'
            ),
            #'description',
            #'keywords',
            array(
                'name'  => 'slug',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->slug, array("/album/$data->slug"))',
            ),
            array(
                'name'        => 'sort_order',
                'type'        => 'raw',
                'value'       => '$this->grid->getUpDownButtons($data)',
                'htmlOptions' => array('style' => 'width: 30px; text-align: center'),
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

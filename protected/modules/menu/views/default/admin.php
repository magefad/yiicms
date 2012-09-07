<?php
$this->breadcrumbs = array(Yii::t('menu', 'Управление меню'));

$this->menu = array(
	//@formatter:off
	array('label' => Yii::t('menu', 'Меню')),
	array('icon' => 'list white', 'label' => Yii::t('menu', 'Управление'), 'url' => array('/menu/default/admin')),
	array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('create')),

	array('label' => Yii::t('menu', 'Пункты меню')),
	array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление'), 'url' => array('item/admin')),
	array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('item/create')),
	//@formatter:on
);

Yii::app()->clientScript->registerScript('search', "
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
");
?>
<?php #echo CHtml::link(Yii::t('page', '<i class="icon-search"></i> Поиск меню <span class="caret"></span>'),'#',array('class' => 'search-button btn btn-small'))?>
<div class="search-form" style="display:none">
	<?php #$this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php
/** @var $model Menu */
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'                    => 'menu-grid',
	'type'                  => 'striped condensed',
	'dataProvider'          => $model->search(),
	'filter'                => $model,
	'rowCssClassExpression' => '($data->status == 2) ? "moderation" : (($data->status) ? "published" : "draft")',
	'columns'               => array(
		array(
			'name'        => 'id',
			'htmlOptions' => array('style'=> 'width: 20px; text-align: center'),
		),
		'name',
		'code',
		'description',
		array(
			'class'=> 'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

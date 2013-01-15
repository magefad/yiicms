<?php

/**
 * @var $model Page
 * @var $this Controller
 */
$this->pageTitle   = Yii::t('user', 'Управление страницами');
$this->breadcrumbs = array(
    Yii::t('page', 'Страницы') => array('admin'),
    Yii::t('page', 'Управление'),
);

Yii::app()->clientScript->registerCss('level', '
td.level-2:before {content: "→ "}
td.level-3:before {content: "—→ "}
td.level-4:before {content: "——→ "}
td.level-5:before {content: "———→ "}
');
Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('page-grid', {
		data: $(this).serialize()
	});
	return false;
});
"
);
?>
<?php echo CHtml::link(
    Yii::t('page', '<i class="icon-search"></i> Поиск страниц <span class="caret"></span>'),
    '#',
    array('class' => 'search-button btn btn-small')
) ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->
<?php $this->widget(
    'FadTbGridView',
    array(
        'id'           => 'page-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            /*array(
                'name'        => 'id',
                'cssClassExpression' => '"level-". $data->level',
                'htmlOptions' => array('style' => 'width: 30px; text-align: center'),
            ),*/ //'update_user_id',
            array(
                'name'  => 'name',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->name, array("update", "id" => $data->id))',
                'cssClassExpression' => '"level-". $data->level',
            ),
            /*array(
                'name'        => 'parent_id',
                'value'       => '$data->parentName',
                'filter'      => Page::model()->treeArray->listData,
                'htmlOptions' => array('style' => 'width: 200px')
            ),*/ #'title',
            array(
                'name'  => 'slug',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->slug, array("show", "slug" => $data->slug), array("target" => "_blank"))',
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
                'name'        => 'sort_order',
                'type'        => 'raw',
                'value'       => '$this->grid->getUpDownButtons($data)',
                'htmlOptions' => array('style' => 'width: 30px; text-align: center'),
            ),
            array(
                'name'        => 'status',
                'type'        => 'raw',
                'value'       => '$this->grid->getStatus($data)',
                'filter'      => array(
                    '' => Yii::t('menu', 'Все'),
                    1  => Yii::t('menu', 'Опубликовано'),
                    0  => Yii::t('menu', 'Черновики'),
                    2  => Yii::t('menu', 'На модерации')
                ),
                'htmlOptions' => array('style' => 'width:40px; text-align:center;'),
            ),
            array(
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width:60px; text-align: center;')
            ),
        ),
    )
); ?>

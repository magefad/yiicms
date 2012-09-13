<?php
$this->breadcrumbs = array(
	Yii::t('news', 'Новости')
);
?>
<h2 style="margin:0">Новости</h2>
<style>
	.news-item {
		margin-bottom: 30px;
	}
	.news-item img {
		float: left;
		padding: 3px 10px 0 0;
		width: 100px;
	}
	.news-item h5 {
		line-height: 16px;
		margin: 0;
	}
	.news-item .label {
		font-size: 11px;
	}
	.news-item p {
		margin: 5px 0 0 0;
	}
</style>
<?php
$this->menu = array(
	array('label' => Yii::t('news', 'Новости')),
	array('icon' => 'list-alt', 'label' => Yii::t('news', 'Управление'), 'url' => array('admin')),
	array('icon' => 'th-list white', 'label' => Yii::t('news', 'Показать анонсами'), 'url' => array('/news/default/index')),
	array('icon' => 'file', 'label' => Yii::t('news', 'Добавить'), 'url' => array('create')),
);
?>
<div class="row">
<?php
/** @var $dataProvider CDataProvider */
$this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider'       => $dataProvider,
	'itemView'           => '_view',
	'sortableAttributes' => array(
		'title',
		'date',
	),
	'htmlOptions'  => array('style' => 'padding-top:0'),
)); ?>
</div>
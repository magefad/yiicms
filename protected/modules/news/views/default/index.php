<?php
/**
 * @var $this Controller
 * @var $dataProvider CDataProvider
 */
$this->breadcrumbs = array(
	Yii::t('news', 'Новости')
);
$css = <<<CSS
.news-item {
    margin-bottom: 30px;
}
.news-item img {
    float: left;
    padding-right: 10px;
}
.news-item h2 {
    font-size: 1.5em;
    line-height: 1;
    margin: 0.2em;
}
.news-item .label {
    font-size: 11px;
}
.news-item p {
    margin-top: 5px;
}
CSS;
Yii::app()->clientScript->registerCss('news', $css);
?>
<h1 style="margin:0"><?php echo Yii::t('news', 'Новости'); ?></h1>
<?php
$this->menu = array(
	array('label' => Yii::t('news', 'Новости')),
	array('icon' => 'list-alt', 'label' => Yii::t('news', 'Управление'), 'url' => array('admin')),
	array('icon' => 'th-list white', 'label' => Yii::t('news', 'Показать анонсами'), 'url' => array('/news/default/index')),
	array('icon' => 'file', 'label' => Yii::t('news', 'Добавить'), 'url' => array('create')),
);
$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider'       => $dataProvider,
        'enableHistory'      => true,
        'itemView'           => '_view',
        'sortableAttributes' => array(
            'title',
            'date',
        ),
        'htmlOptions'        => array('style' => 'padding-top:0'),
        'template'           => '{items}{pager}{summary}{sorter}',
    )
); ?>
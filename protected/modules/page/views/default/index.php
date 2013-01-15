<?php
/**
 * @var $this Controller
 * @var $dataProvider CDataProvider
 */
$this->pageTitle   = Yii::t('page', 'Список страниц');
$this->breadcrumbs = array(Yii::t('page', 'Страницы') => array('admin'));

$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    )
);

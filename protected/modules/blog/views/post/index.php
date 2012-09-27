<?php
/**
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('blog', 'Posts') => array('admin'),
);

$this->menu = array(
    array('label' => Yii::t('blog', 'Posts')),
    array('icon'  => 'list-alt', 'label' => Yii::t('blog', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('blog', 'Create'), 'url' => array('create')),
);
$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    )
);

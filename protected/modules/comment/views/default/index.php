<?php
/**
 * @var $this Controller
 * @var $dataProvider CDataProvider
 */

$this->breadcrumbs = array(Yii::t('CommentModule.comment', 'Comments') => array('admin'));
echo '<h1>' . Yii::t('CommentModule.comment', 'Comments') . '</h1>';

$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    )
);

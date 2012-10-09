<?php
/**
 * @var $this Controller
 * @var $dataProvider CDataProvider
 */
$this->breadcrumbs = array(
    Yii::t('comment', 'Comments') => array('admin'),
);

$this->menu = array(
    array('label' => Yii::t('comment', 'Comments')),
    array('icon'  => 'list-alt', 'label' => Yii::t('comment', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('comment', 'Create'), 'url' => array('create')),
);
?>

<h1>Comments</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
)); ?>

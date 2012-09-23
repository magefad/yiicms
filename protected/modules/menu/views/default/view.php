<?php
/**
 * @var $this Controller
 * @var $model Menu
 */
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню') => array('admin'),
    $model->name,
);
$this->menu        = array(
    array('label' => Yii::t('menu', 'Меню')),
    array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('create')),
    array(
        'icon'       => 'trash',
        'label'      => Yii::t('menu', 'Удалить'),
        'url'        => '#',
        'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('menu', 'Уверены?'))
    ),
    array('label' => Yii::t('menu', 'Пункты меню')),
    array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление'), 'url' => array('item/admin')),
    array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить'), 'url' => array('item/create')),
);
?>

<h1><?php echo Yii::t('menu', 'Просмотр меню');?> <?php echo $model->id; ?></h1>
<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'name',
            'code',
            'description',
            'status',
        ),
    )
); ?>

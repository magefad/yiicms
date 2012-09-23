<?php
/**
 * @var $model Photo
 * @var $this Controller
 */
$this->breadcrumbs = array(
    Yii::t('gallery', 'Фотографии') => array('admin'),
    Yii::t('gallery', 'Добавление'),
);

$this->menu = array(
    array('label' => Yii::t('gallery', 'Управление'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('gallery', 'Добавление');?></h1>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "
/**
 * @var \$this Controller
 * @var \$model ".$this->modelClass."
 */
\$this->breadcrumbs = array(
	Yii::t('" . $this->class2id($this->modelClass) . "', '$label') => array('admin'),
	Yii::t('" . $this->class2id($this->modelClass) . "', 'Manage'),
);\n";
?>

$this->menu = array(
    array('label' => Yii::t('<?php echo $this->class2id($this->modelClass); ?>', '<?php echo $this->modelClass; ?>s')),
    array('icon' => 'list-alt', 'label' => Yii::t('<?php echo $this->class2id($this->modelClass) ?>', 'Manage'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('<?php echo $this->class2id($this->modelClass) ?>', 'Create'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<?php echo "<?php echo CHtml::link(Yii::t('" . $this->class2id($this->modelClass) . "', 'Search'), '#', array('class' => 'search-button btn btn-small')); ?>"; ?>

<div class="search-form" style="display:none">
    <?php echo "<?php \$this->renderPartial('_search', array('model' => \$model)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo "<?php"; ?> $this->widget('FadTbGridView', array(
    'id'           => '<?php echo $this->class2id($this->modelClass); ?>-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if(++$count==7)
		echo "\t\t/*\n";
	echo "\t\t'".$column->name."',\n";
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

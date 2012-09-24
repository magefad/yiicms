<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "
/**
 * @var \$this Controller
 * @var \$model {$this->modelClass}
 */
\$this->breadcrumbs = array(
	Yii::t('" . $this->class2id($this->modelClass) . "', '$label') => array('admin'),
	\$model->{$nameColumn},
);\n";
?>

$this->menu = array(
    array('label' => Yii::t('<?php echo $this->class2id($this->modelClass); ?>', '<?php echo $this->modelClass; ?>s')),
    array('icon'  => 'list-alt', 'label' => Yii::t('<?php echo $this->class2id($this->modelClass) ?>', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('<?php echo $this->class2id($this->modelClass) ?>', 'Create'), 'url' => array('create')),
    array('icon'  => 'pencil', 'label' => Yii::t('<?php echo $this->class2id($this->modelClass) ?>', 'Update'), 'url' => array('update', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('icon'  => 'remove', 'label' => Yii::t('<?php echo $this->class2id($this->modelClass) ?>', 'Delete'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model-><?php echo $this->tableSchema->primaryKey; ?>), 'confirm' => Yii::t('<?php echo $this->class2id($this->modelClass) ?>', 'Are you sure you want to delete this item?'))),
);
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'       => $model,
	'attributes' => array(
<?php
foreach($this->tableSchema->columns as $column)
	echo "\t\t'".$column->name."',\n";
?>
	),
));

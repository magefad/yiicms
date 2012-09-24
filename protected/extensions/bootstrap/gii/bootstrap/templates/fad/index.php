<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs = array(
    Yii::t('" . $this->class2id($this->modelClass) . "', '$label') => array('admin'),
);\n";
?>

$this->menu = array(
    array('label' => Yii::t('<?php echo $this->class2id($this->modelClass); ?>', '<?php echo $this->modelClass; ?>s')),
    array('icon'  => 'list-alt', 'label' => Yii::t('<?php echo $this->class2id($this->modelClass)?>', 'Manage'), 'url' => array('admin')),
    array('icon'  => 'file', 'label' => Yii::t('<?php echo $this->class2id($this->modelClass)?>', 'Create'), 'url' => array('create')),
);
?>

<h1><?php echo $label; ?></h1>

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbListView',array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
)); ?>

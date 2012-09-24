<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php
/**
 * @var \$form TBActiveForm
 * @var \$this Controller
 * @var \$model " . $this->modelClass . "
 */
\$form = \$this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl(\$this->route),
        'method' => 'get',
    )
); ?>\n"; ?>

<?php foreach ($this->tableSchema->columns as $column): ?>
<?php
    $field = $this->generateInputField($this->modelClass, $column);
    if (strpos($field, 'password') !== false) {
        continue;
    }
    ?>
<?php echo "<?php echo " . $this->generateActiveRow($this->modelClass, $column) . "; ?>"; ?>

<?php endforeach; ?>
<div class="form-actions">
    <?php echo "<?php \$this->widget('bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('" . $this->class2id($this->modelClass) . "', 'Search'),
    )
); ?>\n"; ?>
</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
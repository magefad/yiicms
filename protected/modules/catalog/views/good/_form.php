
<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $good Good
 * @var $goodData GoodData[]
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'good-form',
        'enableAjaxValidation' => false,
        'type'                 => 'horizontal',
        'htmlOptions'          => array('class' => 'well')
    )
);
echo $form->errorSummary($good);
echo $form->errorSummary($goodData); ?>
<div class="row-fluid">
    <div class="row">
        <div class="span6">
            <?php foreach ($goodData as $key => $_goodData) {
                /** @var GoodTemplate $template */
                $template = GoodTemplate::model()->findByAttributes(array('key' => $key));
                //$_goodData->setAttribute('key', $template->key);
                echo '<div class="control-group"><label class="control-label">' . $template->name . '</label><div class="controls">';
                $method = GoodTemplate::getFormMethod($template->input_type);
                //echo $form->hiddenField($_goodData, "[$key]key");
                if (is_string($method)) {
                    echo $form->{GoodTemplate::getFormMethod($template->input_type)}($_goodData, "[$key]value", array('class' => 'span12'));
                } else if (is_array($method)) {
                    echo $form->textField($_goodData, "[$key]value", array('class' => 'span12', 'onclick' => "jQuery('#elFinder$key').show('fast')", 'onchange' => "jQuery('#elFinder$key').hide('fast')"));
                    echo '<div id="elFinder' . $key . '" class="hide">';
                    $this->widget(
                        $method['name'],
                        array_merge(
                            $method['properties'],
                            array(
                                'settings' => array(
                                    'editorCallback' => 'js: function(url) {$("#GoodData_' . $key . '_value").val(url); $("#elFinder' . $key . '").hide("fast")}',
                                    'closeOnEditorCallback' => false,
                                )
                            )
                        )
                    );
                    echo '</div>';
                }
                echo '</div></div>';
            }?>
        </div>
        <div class="span6">
            <?php echo $form->dropDownListRow($good, 'page_id', CHtml::listData(Page::model()->catalog()->findAll(), 'id', 'name'), array('class'=>'span12')); ?>
            <?php echo $form->textFieldRow($good, 'name',array('class'=>'span12')); ?>
            <?php echo $form->textFieldRow($good, 'title',array('class'=>'span12')); ?>
            <?php echo $form->textFieldRow($good, 'keywords',array('class'=>'span12')); ?>
            <?php echo $form->textFieldRow($good, 'description',array('class'=>'span12')); ?>
            <?php echo $form->textFieldRow($good, 'slug',array('class'=>'span12')); ?>
            <?php echo $form->dropDownListRow($good, 'status', $good->statusMain->getList(), array('class'=>'span12')); ?>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $good->isNewRecord ? Yii::t('CatalogModule.catalog', 'Create') : Yii::t('CatalogModule.catalog', 'Save'),
    )
); ?>
</div>

<?php
$this->endWidget();
if ($good->isNewRecord) {
    $this->widget('ext.syncTranslit.SyncTranslit', array('textAttribute' => 'Good_title'));
}
?>

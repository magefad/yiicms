
<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $catalogItem CatalogItem
 * @var $catalogItemData CatalogItemData[]
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'catalogItem-form',
        'enableAjaxValidation' => false,
        'type'                 => 'horizontal',
        'htmlOptions'          => array('class' => 'well')
    )
);
echo $form->errorSummary($catalogItem);
echo $form->errorSummary($catalogItemData); ?>
<div class="row-fluid">
    <div class="row">
        <div class="span6">
            <?php foreach ($catalogItemData as $key => $_catalogItemData) {
                /** @var CatalogItemTemplate $template */
                $template = CatalogItemTemplate::model()->findByAttributes(array('key' => $key));
                //$_catalogItemData->setAttribute('key', $template->key);
                echo '<div class="control-group"><label class="control-label">' . $template->name . '</label><div class="controls">';
                $method = CatalogItemTemplate::getFormMethod($template->input_type);
                //echo $form->hiddenField($_catalogItemData, "[$key]key");
                if (is_string($method)) {
                    echo $form->{CatalogItemTemplate::getFormMethod($template->input_type)}($_catalogItemData, "[$key]value", array('class' => 'span12'));
                } else if (is_array($method)) {
                    echo $form->textField($_catalogItemData, "[$key]value", array('class' => 'span12', 'onclick' => "jQuery('#elFinder$key').show('fast')", 'onchange' => "jQuery('#elFinder$key').hide('fast')"));
                    echo '<div id="elFinder' . $key . '" class="hide">';
                    $this->widget(
                        $method['name'],
                        array_merge(
                            $method['properties'],
                            array(
                                'settings' => array(
                                    'editorCallback' => 'js: function(url) {$("#CatalogItemData_' . $key . '_value").val(url); $("#elFinder' . $key . '").hide("fast")}',
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
            <?php echo $form->dropDownListRow($catalogItem, 'page_id', CHtml::listData(Page::model()->catalog()->findAll(), 'id', 'name'), array('class'=>'span12')); ?>
            <?php echo $form->textFieldRow($catalogItem, 'name',array('class'=>'span12')); ?>
            <?php echo $form->textFieldRow($catalogItem, 'title',array('class'=>'span12')); ?>
            <?php echo $form->textFieldRow($catalogItem, 'keywords',array('class'=>'span12')); ?>
            <?php echo $form->textFieldRow($catalogItem, 'description',array('class'=>'span12')); ?>
            <?php echo $form->textFieldRow($catalogItem, 'slug',array('class'=>'span12')); ?>
            <?php echo $form->dropDownListRow($catalogItem, 'status', $catalogItem->statusMain->getList(), array('class'=>'span12')); ?>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $catalogItem->isNewRecord ? Yii::t('CatalogModule.catalog', 'Create') : Yii::t('CatalogModule.catalog', 'Save'),
    )
); ?>
</div>

<?php
$this->endWidget();
if ($catalogItem->isNewRecord) {
    $this->widget('ext.syncTranslit.SyncTranslit', array('textAttribute' => 'CatalogItem_title'));
}
?>

<?php
/**
 * EJuiDateTimePicker displays a DateTimePicker or TimePicker.
 *
 * EJuiDateTimePicker encapsulates the {@link http://trentrichardson.com/examples/timepicker/} addon.
 *
 * To use this widget, you may insert the following code in a view:
 * <pre>
 * $this->widget('ext.jui.EJuiDateTimePicker', array(
 *     'model'     => $model,
 *     'attribute' => 'publish_time',
 *     // additional javascript options for the datetime picker plugin
 *     'options' => array(
 *         'dateFormat' => 'yy-mm-dd',
 *     ),
 *     'htmlOptions' => array(
 *         'style' => 'height:20px;'
 *     ),
 * ));
 * </pre>
 *
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 */

Yii::import('zii.widgets.jui.CJuiDatePicker');
class EJuiDateTimePicker extends CJuiDatePicker
{
    public $mode = 'datetime';

    public function init()
    {
        if (!in_array($this->mode, array('date', 'time', 'datetime'))) {
            throw new CException('CJuiDatePicker unknown mode "' . $this->mode . '". Use time, datetime or date!');
        }
        if (empty($this->language)) {
            $this->language = Yii::app()->language;
        }
        parent::init();
    }

    public function run()
    {
        if ($this->mode == 'date') {
            parent::run();
        }
        else {
            list($name, $id) = $this->resolveNameID();

            if (isset($this->htmlOptions['id'])) {
                $id = $this->htmlOptions['id'];
            } else {
                $this->htmlOptions['id'] = $id;
            }
            if (isset($this->htmlOptions['name'])) {
                $name = $this->htmlOptions['name'];
            }

            if ($this->flat === false) {
                if ($this->hasModel()) {
                    echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
                } else {
                    echo CHtml::textField($name, $this->value, $this->htmlOptions);
                }
            } else {
                if ($this->hasModel()) {
                    echo CHtml::activeHiddenField($this->model, $this->attribute, $this->htmlOptions);
                    $attribute = $this->attribute;
                    $this->options['defaultDate'] = $this->model->$attribute;
                } else {
                    echo CHtml::hiddenField($name, $this->value, $this->htmlOptions);
                    $this->options['defaultDate'] = $this->value;
                }

                if (!isset($this->options['onSelect'])) {
                    $this->options['onSelect'] = new CJavaScriptExpression("function( selectedDate ) { jQuery('#{$id}').val(selectedDate);}");
                }

                $id = $this->htmlOptions['id'] = $id . '_container';
                $this->htmlOptions['name']     = $name . '_container';

                echo CHtml::tag('div', $this->htmlOptions, '');
            }

            //set now time..
            $this->options['hour']   = date('H');
            $this->options['minute'] = date('i');
            $this->options['second'] = date('s');
            $options                 = CJavaScript::encode($this->options);
            $js                      = "jQuery('#{$id}').{$this->mode}picker($options);";

            $assetsDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
            $assets    = Yii::app()->assetManager->publish($assetsDir);
            $cs        = Yii::app()->clientScript;
            $min       = YII_DEBUG ? '' : '.min';
            $cs->registerCssFile($assets . '/jquery-ui-timepicker-addon.css');
            $cs->registerScriptFile($assets . '/jquery-ui-timepicker-addon' . $min . '.js', CClientScript::POS_END);

            if ($this->language != 'en') {
                $this->registerScriptFile($this->i18nScriptFile);
                //TimePicker localization load..
                $i18nScriptFile = 'jquery-ui-timepicker-' . $this->language . '.js';
                $i18nScriptPath = $assetsDir . DIRECTORY_SEPARATOR . 'localization' . DIRECTORY_SEPARATOR . $i18nScriptFile;
                if (file_exists($i18nScriptPath)) {
                    $cs->registerScriptFile($assets . '/localization/' . $i18nScriptFile, CClientScript::POS_END);
                }
                $js = "jQuery('#{$id}').{$this->mode}picker(jQuery.extend(jQuery.datepicker.regional['{$this->language}'], {$options}));";
            }
            if (isset($this->defaultOptions)) {
                $this->registerScriptFile($this->i18nScriptFile);
                $cs->registerScript(__CLASS__, $this->defaultOptions !== null ? "jQuery.{$this->mode}picker.setDefaults(" . CJavaScript::encode($this->defaultOptions) . ');' : '');
            }
            $cs->registerScript(__CLASS__ . '#' . $id, $js);
        }
    }
}

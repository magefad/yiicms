<?php
/**
 * @author Ruslan Fadeev
 * Created: 17.10.12 1:00
 */
class AceEditor extends CInputWidget
{
    public $theme = 'textmate';
    public $mode = 'html';
    public $position = 'relative';
    public $width = '100%';
    public $height = '380px';

    public function run()
    {
        $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'src' . (!YII_DEBUG ? '-min' : ''));
        $cs     = Yii::app()->getClientScript();
        $cs->registerCss($this->getId(), '#' . $this->getId() . ' {position:' . $this->position .'; width: ' . $this->width .'; height: ' . $this->height);
        $cs->registerScriptFile($assets . '/ace.js');
        $cs->registerScriptFile($assets . '/mode-' . $this->mode . '.js');

        $script = <<<JS
var editor = ace.edit("{$this->getId()}");
editor.setShowPrintMargin(false);
//editor.session.setFoldStyle("markbeginend");
editor.setTheme("ace/theme/{$this->theme}");
var Mode = require("ace/mode/{$this->mode}").Mode;
editor.getSession().setMode(new Mode());
JS;
        $cs->registerScript($this->getId(), $script);

        if ($this->hasModel()) {
            echo CHtml::tag('div', array('id' => $this->getId()), CHtml::encode($this->model->{$this->attribute}));
        } else if ($this->name) {
            echo CHtml::tag('div', array('id' => $this->getId(), 'class' => $this->name));
        } else {
            echo Yii::t('zii', '{class} must specify "model" and "{attribute}" or "{name}" property values.', array('{class}' => get_class($this), '{attribute}' => 'attribute', '{name}' => 'name'));
        }
    }
}

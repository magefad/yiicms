<?php
/**
 * User: fad
 * Date: 17.10.12
 * Time: 1:00
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
        $id     = 'ace_' . $this->id;
        $assets = Yii::app()->assetManager->publish(dirname(__FILE__) . '/assets');
        $cs     = Yii::app()->clientScript;
        $cs->registerCss($id, '#' . $id . ' {position:' . $this->position .'; width: ' . $this->width .'; height: ' . $this->height);
        $cs->registerScriptFile($assets . '/ace.js');
        $cs->registerScriptFile($assets . '/theme-' . $this->theme . '.js');
        $cs->registerScriptFile($assets . '/mode-' . $this->mode . '.js');

        $script = 'var editor = ace.edit("' . $id . '");';
        $script .= 'editor.setShowPrintMargin(false);';
        #$script .= 'editor.session.setFoldStyle("markbeginend");';
        $script .= 'editor.setTheme("ace/theme/' . $this->theme . '");';
        $script .= 'var Mode=require("ace/mode/' . $this->mode . '").Mode; editor.getSession().setMode(new Mode());';
        $cs->registerScript($id, $script);

        if ( $this->hasModel() ) {
            echo CHtml::tag('div', array('id' => $id), CHtml::encode($this->model->{$this->attribute}));
        } else {
            echo 'Ace Editor: No model or attribute';
        }
    }
}

<?php

Yii::import('ext.tinymce.*');

class TinyMceElFinder extends TinyMceFileManager
{
    public $settings = array();
    public $connectorRoute =false;
    private $assetsDir;

    private $_id;
    private static $_counter = 0;

    public function init()
    {
        $dir = dirname(__FILE__) . '/assets';
        $this->assetsDir = Yii::app()->assetManager->publish($dir);
        $cs = Yii::app()->getClientScript();

        // jQuery and jQuery UI
        $cs->registerCssFile($cs->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');
//        $cs->registerCssFile($this->assetsDir . '/smoothness/jquery-ui-1.8.21.custom.css');
//        $cs->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/smoothness/jquery-ui.css');
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('jquery.ui');
//        $cs->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js');

        // elFinder CSS
        $cs->registerCssFile($this->assetsDir . '/css/elfinder.css');

        // elFinder JS
        $cs->registerScriptFile($this->assetsDir . '/js/elfinder.min.js');
        // elFinder translation
        $cs->registerScriptFile($this->assetsDir . '/js/i18n/elfinder.ru.js');

        // set required options
        if (empty($this->connectorRoute))
            throw new CException('$connectorRoute must be set!');
        $this->settings['url'] = Yii::app()->createUrl($this->connectorRoute);
        $this->settings['lang'] = Yii::app()->language;
    }

    public function getId()
    {
        if ($this->_id !== null)
            return $this->_id;
        else
            return $this->_id = 'elfd' . self::$_counter++;
    }

    public function getFileBrowserCallback()
    {
        $connectorUrl = $this->settings['url'];
        $id = $this->getId();
        $settings = array_merge(array(
                'places' => "",
                'rememberLastDir' => false,),
            $this->settings
        );

        $settings['dialog'] = array(
            'zIndex' => 400001,
            'width' => 900,
            'modal' => true,
            'title' => "Files",
        );
        $settings['editorCallback'] = 'js:function(url) {
                        aWin.document.forms[0].elements[aFieldName].value = url;
                        if (type == "image" && aFieldName=="src" && aWin.ImageDialog.showPreviewImage)
                            aWin.ImageDialog.showPreviewImage(url);
                    }';
        $settings['closeOnEditorCallback'] = true;

        $settings = CJavaScript::encode($settings);
        $script = <<<EOD
        function(field_name, url, type, win) {
            var aFieldName = field_name, aWin = win;
            if($("#$id").length == 0) {
                $("body").append($("<div/>").attr("id", "$id"));
                $("#$id").elfinder($settings);
            }
            else {
                $("#$id").elfinder("open","$connectorUrl");
            }
        }
EOD;
        return 'js:' . $script;
    }
}

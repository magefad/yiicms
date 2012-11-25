<?php

require_once(dirname(__FILE__) . '/TinyMceCompressorAction.php');

/**
 * @property
 */
class TinyMce extends CInputWidget
{
    /** @var bool|string Route to compressor action */
    public $compressorRoute = false;

    /**
     * @deprecated use spellcheckerUrl instead
     * @var bool|string Route to spellchecker action
     */
    public $spellcheckerRoute = false;

    /**
     * For example here could be url to yandex spellchecker service.
     * http://speller.yandex.net/services/tinyspell
     * More info about it here: http://api.yandex.ru/speller/doc/dg/tasks/how-to-spellcheck-tinymce.xml
     *
     * @var bool|string|array URL or an action route that can be used to create a URL or false if no url
     */
    public $spellcheckerUrl = false;

    private $assetsDir;
    /** @var bool|string Must be set to force widget language */
    public $language = false; // editor language, if false app language is used
    /**
     * @var bool|array FileManager configuration.
     * For example:
     * 'fileManager' => array(
     *      'class' => 'ext.elFinder.TinyMceElFinder',
     *      'connectorRoute'=>'admin/elfinder/connector',
     * )
     */
    public $fileManager = false;

    /** @var array Supported languages */
    private static $languages = array(
        'ar', 'az', 'be', 'bg', 'bn', 'br', 'bs', 'ca', 'ch', 'cn', 'cs', 'cy', 'da', 'de', 'dv', 'el', 'en', 'eo',
        'es', 'et', 'eu', 'fa', 'fi', 'fr', 'gl', 'gu', 'he', 'hi', 'hr', 'hu', 'hy', 'ia', 'id', 'is',
        'it', 'ja', 'ka', 'kl', 'km', 'ko', 'lb', 'lt', 'lv', 'mk', 'ml', 'mn', 'ms', 'my', 'nb', 'nl',
        'nn', 'no', 'pl', 'ps', 'pt', 'ro', 'ru', 'sc', 'se', 'si', 'sk', 'sl', 'sq', 'sr', 'sv', 'sy',
        'ta', 'te', 'th', 'tn', 'tr', 'tt', 'tw', 'uk', 'ur', 'vi', 'zh_cn', 'zh_tw', 'zh', 'zu',); // widget supported languages


    private static $defaultSettings = array(
        'language' => 'ru',
        // General options
        'theme' => "advanced",
//        'skin' => 'o2k7',
//        'skin_variant' => "silver",
//        'skin_variant' => "black",
//        'skin' => 'thebigreason',
        'skin' => 'cirkuit',

        'plugins' => "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

        // Theme options
        'theme_advanced_buttons1' => "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        'theme_advanced_buttons2' => "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        'theme_advanced_buttons3' => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,spellchecker",
        'theme_advanced_buttons4' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
        'theme_advanced_toolbar_location' => "top",
        'theme_advanced_toolbar_align' => "left",
        'theme_advanced_statusbar_location' => "bottom",
        'theme_advanced_resizing' => true,
        'height' => '400px',
        'relative_urls' => false,

        'spellchecker_languages' => "+Русский=ru",


        // Example content CSS (should be your site CSS)
        //content_css : "css/content.css",

        // Drop lists for link/image/media/template dialogs
        //'template_external_list_url' => "lists/template_list.js",
        //'external_link_list_url' => "lists/link_list.js",
        //'external_image_list_url' => "lists/image_list.js",
        //'media_external_list_url' => "lists/media_list.js",

        // Replace values for the template plugin
        'template_replace_values' => array(),


    );
    /** @var array Widget settings will override defaultSettings */
    public $settings = array();

    public function init()
    {
        $dir = dirname(__FILE__) . '/vendors/tinymce/jscripts/tiny_mce';
        $this->assetsDir = Yii::app()->assetManager->publish($dir);
        $this->settings = array_merge(self::$defaultSettings, $this->settings);
        if ($this->language === false)
            $this->settings['language'] = Yii::app()->language;
        else
            $this->settings['language'] = $this->language;
        if (!in_array($this->settings['language'], self::$languages)) {
            $lang = false;
            foreach (self::$languages as $i) {
                if (strpos($this->settings['language'], $i))
                    $lang = $i;
            }
            if ($lang !== false)
                $this->settings['language'] = $lang;
            else
                $this->settings['language'] = 'en';
        }
        $this->settings['language'] = strtr($this->settings['language'], '_', '-');

        $this->settings['script_url'] = "{$this->assetsDir}/tiny_mce.js";
        if(false!==$this->spellcheckerRoute && false ===$this->spellcheckerUrl)
            $this->spellcheckerUrl = Yii::app()->createUrl($this->spellcheckerRoute);

        if ($this->spellcheckerUrl !== false) {
            $this->settings['plugins'] .= ',spellchecker';
            $this->settings['spellchecker_rpc_url'] = CHtml::normalizeUrl($this->spellcheckerUrl);
        }

    }

    public function run()
    {
        list($name, $id) = $this->resolveNameID();
        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;
        if (isset($this->htmlOptions['name']))
            $name = $this->htmlOptions['name'];

        if (isset($this->model)) {
            echo CHtml::textArea($name, CHtml::resolveValue($this->model, $this->attribute), $this->htmlOptions);
        } else {
            echo CHtml::textArea($name, $this->value, $this->htmlOptions);
        }
        $this->registerScripts($id);
    }

    private function registerScripts($id)
    {
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        if ($this->compressorRoute === false) {
            $cs->registerScriptFile($this->assetsDir . '/tiny_mce.js');
            $cs->registerScriptFile($this->assetsDir . '/jquery.tinymce.js');
        } else {
            $cs->registerScriptFile(TinyMceCompressorAction::scripUrl($this->compressorRoute, array(
                "plugins" => $this->settings['plugins'],
                "themes" => $this->settings['theme'],
                "languages" => $this->settings['language'],
                'files' => 'jquery.tinymce',
                'source' => defined('YII_DEBUG') && YII_DEBUG,
            )));
        }
        if ($this->fileManager !== false) {
            /** @var $fm TinyMceFileManager */
            $fm = Yii::createComponent($this->fileManager);
            $fm->init();
            $this->settings['file_browser_callback'] = $fm->getFileBrowserCallback();
        }

        $settings = CJavaScript::encode($this->settings);

        $cs->registerScript("{$id}_tinyMce_init", "$('#{$id}').tinymce({$settings});");
    }
}

<?php
/**
 * Galleria
 * =========
 * Yii framework extension to support galleria javascript image gallery.
 * Links:
 * - Extension site: http://www.yiiframework.com/extension/galleria
 * - Based on extension: http://www.yiiframework.com/extension/egalleria
 * - Galleria:  * - Galleria: http://galleria.io/*
 *
 * @version 0.1
 * @author Fadeev Ruslan
 **/
class Galleria extends CWidget
{
    /**
     * DataProvider passed by user.
     *
     * @array CDataProvider
     **/
    public $dataProvider = null;

    /**
     * Available galleria options.
     * Loaded form galleria/galleria.availableOptions.php
     *
     * @var array
     **/
    private $availableOptions = array();

    /**
     * Widget options overwrite default available options
     * Details: http://galleria.io/docs/options/
     * @var array
     */
    public $options = array();

    /**
     * @var array default options
     */
    public static $defaultOptions = array('transition' => 'fade', 'debug' => YII_DEBUG);

    /**
     * Binding between model passed in dataProvider
     * This can be defined with behaviors() or in
     * the initialization of this widget.
     *
     * @var array
     **/
    public $binding = null;

    /**
     * Widget optional Prefix
     * Example: imagePrefix{$imagePrefixSeparator}image
     * @var string
     */
    public $imagePrefixSeparator = '';

    /**
     * Widget optional src "path" for image
     * @var string
     */
    public $srcPrefix = '';

    /**
     * Widget optional src "path" for thumb
     * @var string
     */
    public $srcPrefixThumb = '';

    /**
     * Widget overwrite classic theme if specified
     * Galleria themes: http://galleria.io/themes/
     * @var string
     */
    public $themeName = 'classic';

    /**
     * Widget overwrite plugins if specified
     * Galleria plugins: http://galleria.io/docs/#plugins
     * @var array
     */
    public $plugins = array('history');

    public $assets;


    public function init()
    {
        $this->initGalleria();
        $this->assets = Yii::app()->assetManager->publish(dirname(__FILE__) . '/assets');
        echo "<div id='galleria_" . $this->id . "' >";
    }

    /** Render Widget */
    public function run()
    {
        /** @var $cs CClientScript */
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');

        //load theme CSS
        $cs->registerCssFile($this->assets . '/themes/' . $this->themeName . '/galleria.' . $this->themeName . '.css');

        $ext = YII_DEBUG ? '.js' : '.min.js';

        $cs->registerScriptFile($this->assets . '/galleria' . $ext);
        $cs->registerScriptFile($this->assets . '/themes/' . $this->themeName . '/galleria.' . $this->themeName . $ext);

        /** load plugins */
        foreach ($this->plugins as $plugin) {
            $cs->registerScriptFile($this->assets . '/plugins/' . $plugin . '/galleria.' . $plugin . $ext);
        }

        $galleriaScript = '$("#galleria_' . $this->id . '").galleria(' . CJSON::encode(array_merge(self::$defaultOptions, $this->options)) . ');';
        $cs->registerScript("galleria_script_" . $this->id, $galleriaScript);

        $dataProvided = $this->dataCheck();
        if ($dataProvided) {
            $this->render(
                'galleria',
                array(
                    'bind'                 => $this->binding,
                    'data'                 => $this->dataProvider,
                    'imagePrefixSeparator' => $this->imagePrefixSeparator, //optional
                    'srcPrefix'            => $this->srcPrefix, //optional
                    'srcPrefixThumb'       => $this->srcPrefixThumb, //optional
                )
            );
        }
        echo '</div>';
    }

    /**
     * Check if data is provided to the widget.
     * If data are provided it checks for the binding as well.
     * If data is set and not binding then it returns false.
     * In other cases returns false;
     *
     * @return boolean
     **/
    public function dataCheck()
    {
        if (isset($this->dataProvider)) {
            if (isset($this->binding) && isset($this->binding['image'])) {
                return true;
            }
            $behavior = $this->dataProvider->model->behaviors();
            if (!empty($behavior)) {
                foreach ($behavior as $name => $bind) {
                    if (strtolower($name) == 'galleria') {
                        $this->binding = $bind;
                    }
                }
                if (isset($this->binding) && isset($this->binding['image'])) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Set options by user from widget
     */
    private function initGalleria()
    {
        $this->availableOptions = require(dirname(__FILE__) . DIRECTORY_SEPARATOR . "galleria.availableOptions.php");
        $initialize             = array();
        if (is_array($this->options)) {
            foreach ($this->options as $option => $value) {
                if (in_array($option, $this->availableOptions)) {
                    $initialize[$option] = $value;
                }
            }
        }
        $initialize['height'] = isset($initialize['height']) ? $initialize['height'] : '0.5625';
        $this->options        = $initialize;
    }
}

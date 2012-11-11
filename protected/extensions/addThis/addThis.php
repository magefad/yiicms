<?php
/**
 * addThis widget class file.
 *
 * @author Fadeev Ruslan
 */

/**
 * addThis extends CWidget and implements a base class for a simple addThis widget.
 * more about addThis can be found on http://www.addthis.com
 * addThis API document can be found on http://www.addthis.com/help/api-overview
 */

class addThis extends CWidget
{
    /**
     * @see http://www.addthis.com/get/sharing?frm=hp
     * @var string pubid on addThis.
     */
    public $pubid;

    /**
     * @see http://vk.com/developers.php?oid=-1&p=Like
     * @var integer Vkontakte API Id if vkLike used
     */
    public $vkApiId;

    /**
     * @see http://vk.com/developers.php?oid=-1&p=Like
     * @var array
     */
    public $vkButtonOptions = array('type' => 'mini', 'height' => 18);

    /** @var boolean whether the default addThis button is visible. Defaults to true. */
    public $singleButton = false;

    /** @var array the addThis default button a tag attributes. */
    public $singleButtonOptions = array('class' => 'addthis_button');

    /** @var array the addThis div tag attributes. */
    public $htmlOptions = array();

    /**
     * @var array the addThis services to show.
     * $serviceName => htmlOptions
     */
    public $services = array(
        'vk_like'        => array('style' => 'float: left!important;width: 90px!important;padding-top: 1px;'),
        'facebook_like'  => array('fb:like:layout' => 'button_count', 'fb:like:width' => 135),
        'tweet'          => array('style' => 'width:105px !important'),
        'google_plusone' => array('g:plusone:size' => 'medium', 'style' => 'width:70px'),
        'livejournal'    => array('style' => 'padding-top: 2px')
    );

    /** @var array the addThis config parameters. */
    public $config = array('ui_click' => 'true');

    /** @var array the addThis share parameters. */
    public $share = array();

    public function init()
    {
        parent::init();
        if (empty($this->pubid)) {
            throw new Exception(Yii::t('yii', 'Property "{class}.{property}" is not defined.', array('{class}' => 'addThis', '{property}' => 'pubid')));
        }
        $js = array();
        Yii::app()->clientScript->registerScriptFile("http://s7.addthis.com/js/300/addthis_widget.js#pubid={$this->pubid}");

        if (!empty($this->vkApiId) && is_int($this->vkApiId)) {
            Yii::app()->clientScript->registerScriptFile('http://userapi.com/js/api/openapi.js');
            $js[] = 'VK.init('.CJavaScript::encode(array('apiId' => $this->vkApiId, 'onlyWidgets' => true)).');';

            Yii::app()->clientScript->registerScript(__CLASS__ . '#vk', 'VK.Widgets.Like("vk_like", '.CJavaScript::encode($this->vkButtonOptions).');', CClientScript::POS_END);
        }

        $this->config['ui_language'] = isset($this->config['ui_language']) ? $this->config['ui_language'] : Yii::app()->language;
        if (!empty($this->config)) {
            $js[] = 'var addthis_config=' . CJavaScript::encode($this->config);
        }
        if (!empty($this->share)) {
            $js[] = 'var addthis_share=' . CJavaScript::encode($this->share);
        }
        Yii::app()->clientScript->registerScript(__CLASS__ . '#', implode("\r\n", $js), CClientScript::POS_HEAD);

        $this->htmlOptions['id'] = $this->id;
        if (!isset($this->htmlOptions['class'])) {
            $this->htmlOptions['class'] = 'addthis_default_style';
        }
        if (!isset($this->htmlOptions['style'])) {
            $this->htmlOptions['style'] = 'padding: 5px 0 5px 5px';
        }
        $this->htmlOptions['class'] = 'addthis_toolbox ' . $this->htmlOptions['class'];
    }

    /**
     * Run the addThis widget.
     * This renders the body part of the assThis widget.
     */
    function run()
    {
        // Run parent CWidget run function.
        parent::run();
        echo '<!-- AddThis Button BEGIN -->';
        echo CHtml::openTag('div', $this->htmlOptions) . "\n";
        if ($this->singleButton) {
            $img = CHtml::image("http://s7.addthis.com/static/btn/v2/lg-share-{$this->config['ui_language']}.gif", Yii::t('addThis', 'Bookmark and Share'));
            echo CHtml::link($img, "http://www.addthis.com/bookmark.php?v=300&amp;#pubid={$this->pubid}", $this->singleButtonOptions);
        }

        // Check what services to show.
        if (!$this->singleButton && !empty($this->services)) {
            while ($item = current($this->services)) {
                is_array($item) ? $service = array('name' => key($this->services), 'htmlOptions' => $item) : $service = array('name' => $item, 'htmlOptions' => array());
                next($this->services);

                if ($service['name'] == 'vk_like') {
                    if (!empty($this->vkApiId) && is_int($this->vkApiId)) {
                        $service['htmlOptions']['id'] = 'vk_like';
                        echo CHtml::tag('a', $service['htmlOptions'], '');
                    }
                } else {
                    $service['htmlOptions']['class'] = "addthis_button_{$service['name']}";
                    echo CHtml::tag('a', $service['htmlOptions'], '');
                }
            }
        }
        echo CHtml::closeTag('div');
        echo '<!-- AddThis Button END -->';
    }
}

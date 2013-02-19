<?php
/**
 * InlineWidgetsBehavior allows render widgets in page content
 *
 * Config:
 * <code>
 * return array(
 *     // ...
 *     'params'=>array(
 *          // ...
 *         'runtimeWidgets'=>array(
 *             'Share',
 *             'Comments',
 *             'blog.widgets.LastPosts',
 *         }
 *     }
 * }
 * </code>
 *
 * Widget:
 * <code>
 * class LastPostsWidget extends CWidget
 * {
 *     public $tpl='default';
 *     public $limit=3;
 *
 *     public function run()
 *     {
 *         $posts = Post::model()->published()->last($this->limit)->findAll();
 *         $this->render('LastPosts/' . $this->tpl,array(
 *             'posts'=>$posts,
 *         ));
 *     }
 * }
 * </code>
 *
 * Controller:
 * <code>
 * class Controller extends CController
 * {
 *     public function behaviors()
 *     {
 *         return array(
 *             'InlineWidgetsBehavior'=>array(
 *                 'class'=>'InlineWidgetsBehavior',
 *                 'location'=>'application.components.widgets',
 *                 'widgets'=>Yii::app()->params['runtimeWidgets'],
 *              ),
 *         );
 *     }
 * }
 * </code>
 *
 * For rendering widgets in View you must call Controller::decodeWidgets() method:
 * <code>
 * $text = '
 *     <h2>Lorem ipsum</h2>
 *     <p>[*LastPosts*]</p>
 *     <p>[*LastPosts|limit=4*]</p>
 *     <p>[*LastPosts|limit=5;tpl=small*]</p>
 *     <p>[*LastPosts|limit=5;tpl=small|cache=300*]</p>
 *     <p>Dolor...</p>
 * ';
 * echo $this->decodeWidgets($text);
 * </code>
 *
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 * @version 1.0
 */

class InlineWidgetsBehavior extends CBehavior
{
    /**
     * @var string marker of block begin
     */
    public $startBlock = '[*';
    /**
     * @var string marker of block end
     */
    public $endBlock = '*]';
    /**
     * @var string alias if needle using default location 'path.to.widgets'
     */
    public $location = '';
    /**
     * @var string global classname suffix like 'Widget'
     */
    public $classSuffix = '';
    /**
     * @var array of allowed widgets
     */
    public $widgets = array();

    protected $_widgetToken;

    public function __construct()
    {
        $this->_initToken();
    }

    /**
     * Content parser
     * Use $this->decodeWidgets($model->text) in view
     * @param $text
     * @return mixed
     */
    public function decodeWidgets($text)
    {
        $text = $this->_replaceBlocks($text);
        $text = $this->_clearAutoParagraphs($text);
        $text = $this->_processWidgets($text);
        return $text;
    }

    /**
     * @param $text
     * @return mixed|string
     */
    protected function _processWidgets($text)
    {
        if (preg_match('|\{' . $this->_widgetToken . ':.+?' . $this->_widgetToken . '\}|is', $text))
        {
            foreach ($this->widgets as $alias)
            {
                $widget = $this->_getClassByAlias($alias);

                while (preg_match('#\{' . $this->_widgetToken . ':' . $widget . '(\|([^}]*)?)?' . $this->_widgetToken . '\}#is', $text, $p))
                {
                    $text = str_replace($p[0], $this->_loadWidget($alias, isset($p[2]) ? $p[2] : ''), $text);
                }
            }
            return $text;
        }
        return $text;
    }

    protected function _initToken()
    {
        $this->_widgetToken = md5(microtime());
    }

    /**
     * @param $text
     * @return string
     */
    protected function _replaceBlocks($text)
    {
        $text = str_replace($this->startBlock, '{' . $this->_widgetToken . ':', $text);
        $text = str_replace($this->endBlock, $this->_widgetToken . '}', $text);
        return $text;
    }

    /**
     * @param $output
     * @return string
     */
    protected function _clearAutoParagraphs($output)
    {
        $output = str_replace('<p>' . $this->startBlock, $this->startBlock, $output);
        $output = str_replace($this->endBlock . '</p>', $this->endBlock, $output);
        return $output;
    }

    /**
     * @param $name
     * @param string $attributes
     * @return mixed|string
     */
    protected function _loadWidget($name, $attributes='')
    {
        $attributes = $this->_parseAttributes($attributes);
        $cache      = $this->_extractCacheExpireTime($attributes);

        $index = 'widget_' . $name . '_' . serialize($attributes);

        if ($cache && $cachedHtml = Yii::app()->cache->get($index))
        {
            $html = $cachedHtml;
        }
        else
        {
            ob_start();
            $widget = Yii::app()->widgetFactory->createWidget($this->owner, $name, $attributes);
            $widget->run();
            $html = trim(ob_get_clean());
            Yii::app()->cache->set($index, $html, $cache);
        }

        return $html;
    }

    /**
     * @param $attributesString
     * @return array
     */
    protected function _parseAttributes($attributesString)
    {
        $params = explode(';', $attributesString);
        $attributes  = array();

        foreach ($params as $param)
        {
            if ($param)
            {
                list($attribute, $value) = explode('=', $param);
                if ($value) {
                    $attributes[$attribute] = trim($value);
            }
        }
        }

        ksort($attributes);
        return $attributes;
    }

    protected function _extractCacheExpireTime(&$attributes)
    {
        $cache = 0;
        if (isset($attributes['cache'])) {
            $cache = (int)$attributes['cache'];
            unset($attributes['cache']);
        }
        return $cache;
    }

    protected function _getFullClassName($name)
    {
        $widgetClass = $name . $this->classSuffix;
        if ($this->_getClassByAlias($widgetClass) == $widgetClass && $this->location)
            $widgetClass = $this->location . '.' . $widgetClass;
        return $widgetClass;
    }

    protected function _getClassByAlias($alias)
    {
        $paths = explode('.', $alias);
        return array_pop($paths);
    }
}
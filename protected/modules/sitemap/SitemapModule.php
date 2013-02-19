<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 07.12.12
 * Time: 13:13
 * @see http://www.sitemaps.org
 */
class SitemapModule extends WebModule
{
    /**
     * Optional tags
     * example to set some defaults ['lastmod' => '2012-12-12', 'changefreq' => 'daily', 'priority' => '0.5']
     * @var string
     * @see http://www.sitemaps.org/protocol.html
     * @see http://www.sitemaps.org/ru/protocol.html
     */
    public $lastmod = '', $changefreq = '', $priority = '';

    /**
     * @var int 10 minutes in cache
     */
    public $cachingDuration = 600;

    /**
     * @var array List of actions for generating sitemap
     * like example @see $defaultActions
     */
    public $actions = array();

    private static $defaultActions = array(
        'page/default/show'   => array(
            'model' => array(
                'class'      => 'application.modules.page.models.Page',
                'criteria'   => array(
                    'select' => 'level, title, slug, update_time',
                    'scopes' => array('published', 'public'),
                    'order'  => 'sort_order'
                ),
                'params'     => array('slug' => 'slug'),
                'attributes' => array(
                    'lastmod' => 'update_time',
                    'title'   => 'title',
                    'level'   => 'level'
                )
            )
        ),
        'news'                => array(
            'model' => array(
                'class' => 'application.modules.news.NewsModule',
            )
        ),
        'news/default/show'   => array(
            'level' => 2,
            'model' => array(
                'class'      => 'application.modules.news.models.News',
                'criteria'   => array('select' => 'title, slug, update_time', 'scopes' => array('published', 'public')),
                'params'     => array('slug' => 'slug'),
                'attributes' => array(
                    'lastmod' => 'update_time',
                    'title'   => 'title',
                )
            )
        ),
        'gallery'             => array(
            'model' => array(
                'class' => 'application.modules.gallery.GalleryModule',
            )
        ),
        'gallery/photo/album' => array(
            'level' => 2,
            'model' => array(
                'class'      => 'application.modules.gallery.models.Gallery',
                'criteria'   => array('select' => 'title, slug, update_time', 'scopes' => 'public'),
                'params'     => array('slug' => 'slug'),
                'attributes' => array(
                    'lastmod' => 'update_time',
                    'title'   => 'title',
                )
            )
        ),
        'blog'                => array(
            'model' => array(
                'class' => 'application.modules.blog.BlogModule',
            )
        ),
        'blog/default/show'   => array(
            'level' => 2,
            'model' => array(
                'class'      => 'application.modules.blog.models.Blog',
                'import'     => array(
                    'application.modules.blog.BlogModule',
                    'application.modules.blog.models.UserBlog'
                ),
                'criteria'   => array(
                    'select' => 'title, slug',
                    'scopes' => array('published', 'public'),
                    'with'   => 'lastPostTime'
                ),
                'params'     => array('slug' => 'slug'),
                'attributes' => array(
                    'lastmod' => 'lastPostTime',
                    'title'   => 'title',
                )
            )
        ),
        'blog/post/show'      => array(
            'level'       => 3,
            'htmlDisable' => true,
            'model'       => array(
                'class'      => 'application.modules.blog.models.Post',
                'import'     => 'application.modules.blog.BlogModule',
                'criteria'   => array('select' => 'title, slug, update_time', 'scopes' => array('published', 'public')),
                'params'     => array('slug' => 'slug'),
                'attributes' => array(
                    'lastmod' => 'update_time',
                    'title'   => 'title',
                )
            )
        ),
        'contact'             => array(
            'model' => array(
                'class' => 'application.modules.contact.ContactModule',
            )
        )
    );

    public static function getName()
    {
        return Yii::t('SitemapModule.sitemap', 'Sitemap and sitemap.xml generator');
    }

    public static function getIcon()
    {
        return 'th';
    }

    public function getUrls()
    {
        if ($urls = Yii::app()->getCache()->get(get_class($this))) {
            return $urls;
        }
        $urls = array();
        foreach ($this->actions as $route => $action) {
            $data = array(
                'title'       => isset($action['title']) ? (string)$action['title'] : '',
                'level'       => isset($action['level']) ? (int)$action['level'] : 1,
                'lastmod'     => isset($action['lastmod']) ? isset($action['lastmod']) : $this->lastmod,
                'changefreq'  => isset($action['changefreq']) ? isset($action['lastmod']) : $this->changefreq,
                'priority'    => isset($action['priority']) ? isset($action['lastmod']) : $this->priority,
                'htmlDisable' => isset($action['htmlDisable']) ? (int)$action['htmlDisable'] : false,
            );
            if (isset($action['model'])) {
                //model used to generate params
                if (isset($action['model']['class'])) {
                    if (substr($action['model']['class'], 12, 7) == 'modules') {//application.modules
                        $temp = substr($action['model']['class'], 20);
                        $moduleId = substr($temp, 0, strpos($temp, '.'));
                        if (!Yii::app()->hasModule($moduleId)) {
                            continue;
                        }
                        unset($temp);
                    }
                    Yii::import($action['model']['class']);
                    if (isset($action['model']['import'])) {
                        $this->import($action['model']['import']);
                    }
                    $modelName = substr(strrchr($action['model']['class'], '.'), 1);
                    if (substr($modelName, -6) == 'Module') {
                        if (empty($data['title'])) {
                            /** @var $module WebModule|CWebModule */
                            if (method_exists($modelName, 'getIcon')) {//call static method @todo change check
                                $data['title'] = call_user_func($modelName . '::getName');//call_user_func for support php 5.1...
                            } else {//CWebModule getName non static..
                                $data['title'] = Yii::app()->getModule($moduleId)->name;
                            }
                        }
                        $urls[Yii::app()->createAbsoluteUrl($route)] = $data;
                    } else {
                        $criteria = isset($action['model']['criteria']) ? $action['model']['criteria'] : '';
                        foreach (CActiveRecord::model($modelName)->findAll($criteria) as $model) {
                            /** @var $model CActiveRecord */
                            $action['params'] = array();
                            foreach ($action['model']['params'] as $param => $attribute) {
                                if (!$model->hasAttribute($attribute) && !$model->hasProperty($attribute)) {
                                    throw new CHttpException(500, Yii::t('yii', '{class} and its behaviors do not have a method or closure named "{name}".', array('{class}' => $modelName, '{name}' => $attribute)));
                                }
                                $action['params'][$param] = $model->{$attribute};
                            }
                            if (isset($action['model']['attributes'])) {
                                foreach ($action['model']['attributes'] as $name => $attribute) {
                                    if (isset($model->{$attribute})) {
                                        if ($name == 'lastmod') {
                                            $data['lastmod'] = date('c', strtotime($model->{$attribute}));
                                        } else {
                                            $data[$name] = $model->{$attribute};
                                        }
                                    }
                                }
                            }
                            $urls[Yii::app()->createAbsoluteUrl($route, $action['params'])] = $data;
                        }
                    }
                } //array used to generate params
                else if (isset($action['options']['array'])) {
                    foreach ($action['options']['array'] as $params) {
                        $urls[Yii::app()->createAbsoluteUrl($route, $params)] = $data;
                    }
                }
            } //no params
            else {
                $urls[Yii::app()->createAbsoluteUrl($route, isset($action['params']) ? $action['params'] : array())] = $data;
            }
        }
        Yii::app()->getCache()->set(get_class($this), $urls, $this->cachingDuration);
        return $urls;
    }

    /**
     * Imports a class or a classes (if array)
     * @param array|string $alias
     */
    private function import($alias)
    {
        if (is_array($alias)) {
            foreach ($alias as $class) {
                Yii::import($class);
            }
        } else {
            Yii::import($alias);
        }
    }

    public function init()
    {
        $this->actions = array_merge(self::$defaultActions, $this->actions);
    }
}

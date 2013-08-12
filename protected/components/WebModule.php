<?php
/**
 * WebModule class file.
 *
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 * WebModule represents an application module.
 *
 * An application module may be considered as a self-contained sub-application
 * that has its own controllers, models and views and can be reused in a different
 * project as a whole. Controllers inside a module must be accessed with routes
 * that are prefixed with the module ID.
 *
 * @property string $name The name of this module.
 * @property string $description The description of this module.
 * @property string $version The version of this module.
 * @property string $controllerPath The directory that contains the controller classes. Defaults to 'moduleDir/controllers'
 * where moduleDir is the directory containing the module class.
 * @property string $viewPath The root directory of view files. Defaults to 'moduleDir/views' where moduleDir is
 * the directory containing the module class.
 * @property string $layoutPath The root directory of layout files. Defaults to 'moduleDir/views/layouts' where
 * moduleDir is the directory containing the module class.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.web
 */
class WebModule extends CModule
{
    /**
     * @var string the ID of the default controller for this module. Defaults to 'default'.
     */
    public $defaultController = 'default';

    /**
     * @var mixed the layout that is shared by the controllers inside this module.
     * If a controller has explicitly declared its own {@link CController::layout layout},
     * this property will be ignored.
     * If this is null (default), the application's layout or the parent module's layout (if available)
     * will be used. If this is false, then no layout will be used.
     */
    public $layout = '//layouts/main';

    /**
     * @var string Namespace that should be used when loading controllers.
     * Default is to use global namespace.
     * @since 1.1.11
     */
    public $controllerNamespace;

    /**
     * @var array mapping from controller ID to controller configurations.
     * Please refer to {@link CWebApplication::controllerMap} for more details.
     */
    public $controllerMap = array();

    private $_controllerPath;
    private $_viewPath;
    private $_layoutPath;

    const CHOICE_YES = 1;
    const CHOICE_NO  = 0;

    /**
     * Returns the name of this module.
     * The default implementation simply returns {@link id}.
     * You may override this method to customize the name of this module.
     * @return string the name of this module.
     */
    public static function getName()
    {
        return '';
    }

    /**
     * Returns the description of this module.
     * The default implementation returns an empty string.
     * You may override this method to customize the description of this module.
     * @return string the description of this module.
     */
    public static function getDescription()
    {
        return '';
    }

    /**
     * Returns the version of this module.
     * The default implementation returns '1.0'.
     * You may override this method to customize the version of this module.
     * @return string the version of this module.
     */
    public static function getVersion()
    {
        return '1.0';
    }
    /**
     * Returns the author of this module.
     * @return string the author of this module.
     */
    public static function getAuthor()
    {
        return 'Ruslan Fadeev';
    }

    /**
     * Returns the author email of this module.
     * @return string the author email of this module.
     */
    public static function getAuthorEmail()
    {
        return 'fadeevr@gmail.com';
    }

    /**
     * Returns the site url of this module.
     * @return string the site url of this module.
     */
    public static function getUrl()
    {
        return 'http://yiifad.ru';
    }

    /**
     * Returns the bootstrap icon of this module.
     * @return string the bootstrap icon of this module.
     */
    public static function getIcon()
    {
        return 'cog';
    }

    /**
     * @return array items for TbNavbar
     */
    public function getAdminMenu()
    {
        $menu = array(
            array('icon' => 'list-alt', 'label' => Yii::t('admin', 'Список'), 'url' => array('/' . $this->id . '/' . Yii::app()->controller->id . '/admin')),
            array('icon' => 'file', 'label' => Yii::t('admin', 'Добавить'), 'url' => array('/' . $this->id . '/' . Yii::app()->controller->id . '/create'))
        );
        if (isset(Yii::app()->controller->actionParams['id']) && Yii::app()->controller->id == 'default') {
            $menu[] = array(
                'icon'  => 'pencil',
                'label' => Yii::t('zii', 'Update'),
                'url'   => array(
                    '/' . $this->id . '/' . Yii::app()->controller->id . '/update',
                    'id' => Yii::app()->controller->actionParams['id']
                )
            );
            $menu[] = array(
                'icon'        => 'remove',
                'label'       => Yii::t('zii', 'Delete'),
                'url'         => '#',
                'linkOptions' => array(
                    'submit'  => array('/' . $this->id . '/' . Yii::app()->controller->id . '/delete', 'id' => Yii::app()->controller->actionParams['id']),
                    'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?')
                )
            );
        } else if (!empty($this->settingData)) {
            $menu[] = array(
                'icon'  => 'wrench',
                'label' => Yii::t('admin', 'Настройки'),
                'url'   => array('/admin/setting/update/' . $this->id . '/')
            );
        }
        return $menu;
    }

    /**
     * Returns the setting's labels.
     * @return array setting's labels (name=>label)
     */
    public function getSettingLabels()
    {
        return array();
    }

    /**
     * Returns the setting's data.
     * @example
     * array(
     *      'settingKey1'   => array(
     *          'tag'   => 'textArea',
     *      ),
     *      'settingKey2'   => array(
     *          'value' => array(1 => 'first value', 2 => 'second value'),
     *          'tag'   => 'dropDownList',
     *          'htmlOptions' => array(
     *              'hint' => Yii::t('module_id', 'Hint (help) for input'),
     *      ),
     * ...
     * );
     *
     * @return array setting's data
     */
    public function getSettingData()
    {
        return array();
    }

    /**
     *
     * @return array
     */
    public function getChoice()
    {
        return array(
            self::CHOICE_YES => Yii::t('yii', 'Yes'),
            self::CHOICE_NO  => Yii::t('yii', 'No'),
        );
    }

    /**
     * @return string the directory that contains the controller classes. Defaults to 'moduleDir/controllers' where
     * moduleDir is the directory containing the module class.
     */
    public function getControllerPath()
    {
        if($this->_controllerPath!==null)
            return $this->_controllerPath;
        else
            return $this->_controllerPath=$this->getBasePath().DIRECTORY_SEPARATOR.'controllers';
    }

    /**
     * @param string $value the directory that contains the controller classes.
     * @throws CException if the directory is invalid
     */
    public function setControllerPath($value)
    {
        if(($this->_controllerPath=realpath($value))===false || !is_dir($this->_controllerPath))
            throw new CException(Yii::t('yii','The controller path "{path}" is not a valid directory.',
                array('{path}'=>$value)));
    }

    /**
     * @return string the root directory of view files. Defaults to 'moduleDir/views' where
     * moduleDir is the directory containing the module class.
     */
    public function getViewPath()
    {
        if($this->_viewPath!==null)
            return $this->_viewPath;
        else
            return $this->_viewPath=$this->getBasePath().DIRECTORY_SEPARATOR.'views';
    }

    /**
     * @param string $path the root directory of view files.
     * @throws CException if the directory does not exist.
     */
    public function setViewPath($path)
    {
        if(($this->_viewPath=realpath($path))===false || !is_dir($this->_viewPath))
            throw new CException(Yii::t('yii','The view path "{path}" is not a valid directory.',
                array('{path}'=>$path)));
    }

    /**
     * @return string the root directory of layout files. Defaults to 'moduleDir/views/layouts' where
     * moduleDir is the directory containing the module class.
     */
    public function getLayoutPath()
    {
        if($this->_layoutPath!==null)
            return $this->_layoutPath;
        else
            return $this->_layoutPath=$this->getViewPath().DIRECTORY_SEPARATOR.'layouts';
    }

    /**
     * @param string $path the root directory of layout files.
     * @throws CException if the directory does not exist.
     */
    public function setLayoutPath($path)
    {
        if(($this->_layoutPath=realpath($path))===false || !is_dir($this->_layoutPath))
            throw new CException(Yii::t('yii','The layout path "{path}" is not a valid directory.',
                array('{path}'=>$path)));
    }

    /**
     * The pre-filter for controller actions.
     * This method is invoked before the currently requested controller action and all its filters
     * are executed. You may override this method in the following way:
     * <pre>
     * if(parent::beforeControllerAction($controller,$action))
     * {
     *     // your code
     *     return true;
     * }
     * else
     *     return false;
     * </pre>
     * @param CController $controller the controller
     * @param CAction $action the action
     * @return boolean whether the action should be executed.
     */
    public function beforeControllerAction($controller,$action)
    {
        if(($parent=$this->getParentModule())===null)
            $parent=Yii::app();
        return $parent->beforeControllerAction($controller,$action);
    }

    /**
     * The post-filter for controller actions.
     * This method is invoked after the currently requested controller action and all its filters
     * are executed. If you override this method, make sure you call the parent implementation at the end.
     * @param CController $controller the controller
     * @param CAction $action the action
     */
    public function afterControllerAction($controller,$action)
    {
        if(($parent=$this->getParentModule())===null)
            $parent=Yii::app();
        $parent->afterControllerAction($controller,$action);
    }


    /**
     * Read Settings from DB, if null - use default module property's
     */
    public function init()
    {
        $cacheKey = 'settings_' . $this->id;
        $settings = Yii::app()->getCache()->get($cacheKey);
        if (!is_array($settings)) {
            $dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM {{settings}} WHERE module_id="' . $this->getId() . '"');
            $sql = "SELECT `key`, `value` FROM {{settings}} WHERE module_id='{$this->id}'";
            $settings = Yii::app()->db->cache(3000, $dependency)->createCommand($sql)->queryAll();
            Yii::app()->cache->set($cacheKey, $settings);
        }

        if ($settings) {
            $settingKeys = array_keys($this->settingLabels);
            foreach ($settings as $setting) {
                if (property_exists($this, $setting['key']) && (in_array($setting['key'], $settingKeys))) {
                    $this->{$setting['key']} = $setting['value'];
                }
            }
        }
    }
}

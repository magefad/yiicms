<?php
/**
 * User: fad
 * Date: 05.09.12
 * Time: 12:00
 */
class WebModule extends CWebModule
{
    /**
     * @var mixed the layout that is shared by the controllers inside this module.
     * If a controller has explicitly declared its own {@link CController::layout layout},
     * this property will be ignored.
     */
    public $layout = '//layouts/main';

    const CHOICE_YES = 1;
    const CHOICE_NO  = 0;

    /**
     * Returns the version of this module.
     * The default implementation returns '0.0.1'.
     * @return string the version of this module.
     */
    public function getVersion()
    {
        return '0.0.1';
    }

    /**
     * Returns the description of this module.
     * @return string the description of this module.
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * Returns the author of this module.
     * @return string the author of this module.
     */
    public function getAuthor()
    {
        return 'Ruslan Fadeev';
    }

    /**
     * Returns the author email of this module.
     * @return string the author email of this module.
     */
    public function getAuthorEmail()
    {
        return 'fadeevr@gmail.com';
    }

    /**
     * Returns the site url of this module.
     * @return string the site url of this module.
     */
    public function getUrl()
    {
        return 'http://yiifad.ru';
    }

    /**
     * Returns the bootstrap icon of this module.
     * @return string the bootstrap icon of this module.
     */
    public function getIcon()
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
            self::CHOICE_YES => Yii::t('admin', 'Да'),
            self::CHOICE_NO  => Yii::t('admin', 'Нет'),
        );
    }

    /**
     * Read Settings from DB, if null - use default module property's
     */
    public function init()
    {
        $cacheKey = 'settings_' . $this->id;
        $settings = Yii::app()->cache->get($cacheKey);
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

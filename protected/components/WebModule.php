<?php
/**
 * User: fad
 * Date: 05.09.12
 * Time: 12:00
 */
class WebModule extends CWebModule
{
    const CHECK_ERROR  = 'error';
    const CHECK_NOTICE = 'notice';

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
        return Yii::t('admin', 'Нет описания');
    }

    /**
     * Returns the author of this module.
     * @return string the author of this module.
     */
    public function getAuthor()
    {
        return Yii::t('admin', 'fad');
    }

    /**
     * Returns the author email of this module.
     * @return string the author email of this module.
     */
    public function getAuthorEmail()
    {
        return Yii::t('admin', 'fad@itrade-rus.ru');
    }

    /**
     * Returns the site url of this module.
     * @return string the site url of this module.
     */
    public function getUrl()
    {
        return Yii::t('admin', '');
    }

    /**
     * Returns the bootstrap icon of this module.
     * @return string the bootstrap icon of this module.
     */
    public function getIcon()
    {
        return "cog";
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
        $dependency = new CDbCacheDependency('SELECT UNIX_TIMESTAMP(MAX(change_date)) FROM ' . Setting::model(
        )->tableName() . ' WHERE module_id="' . $this->getId() . '"');

        $settings = Setting::model()->cache(3600, $dependency)->findAll(
            'module_id = :module_id',
            array('module_id' => $this->getId())
        );

        if ($settings) {
            $settingKeys = array_keys($this->settingLabels);
            foreach ($settings as $model) {
                if (property_exists($this, $model->key) && (in_array($model->key, $settingKeys))) {
                    $this->{$model->key} = $model->value;
                }
            }
        }
        parent::init();
    }
}

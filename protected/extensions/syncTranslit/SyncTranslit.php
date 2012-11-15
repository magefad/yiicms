<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 13.11.12
 * Time: 17:11
 */
class SyncTranslit extends CWidget
{
    /**
     * @var string element ID which stored original text
     */
    public $textAttribute;

    public $options  = array();

    public function init()
    {
        parent::init();
        if (empty($this->textAttribute)) {
            throw new Exception(Yii::t('yii', 'Property "{class}.{property}" is not defined.', array('{class}' => 'SyncTranslit', '{property}' => 'textAttribute')));
        }

        $assets    = Yii::app()->assetManager->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');
        Yii::app()->clientScript->registerScriptFile($assets . '/jquery.synctranslit' . (!YII_DEBUG ? '.min' : '') . '.js', CClientScript::POS_END);
    }

    public function run()
    {
        if (!isset($this->options['destination'])) {
            list($model, $attribute) = explode('_', $this->textAttribute);
            $this->options['destination'] = $model ? $model . '_slug' : 'slug';
        }
        $options = CJavaScript::encode($this->options);
        Yii::app()->clientScript->registerScript("{$this->id}_syncTranslit", "$('#{$this->textAttribute}').syncTranslit({$options});", CClientScript::POS_READY);
    }
}

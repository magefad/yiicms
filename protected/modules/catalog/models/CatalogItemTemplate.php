<?php

/**
 * This is the model class for table "{{catalog_item_template}}".
 *
 * The followings are the available columns in table '{{catalog_item_template}}':
 * @property integer $id
 * @property string $key
 * @property string $name
 * @property integer $input_type
 *
 * The followings are the available model relations:
 * @property StatusBehavior $statusInputType
 * @property CatalogItem[] $items
 */
class CatalogItemTemplate extends CActiveRecord
{
    const INPUT_TYPE_TEXT = 0;
    const INPUT_TYPE_TEXTAREA = 1;
    const INPUT_TYPE_FILE = 2;
    const INPUT_TYPE_IMAGE = 3;

    /**
     * @var string old key string
     */
    public $oldKey = '';

    /**
     * @var array key=>name
     */
    private static $_data = array();

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CatalogItemTemplate the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{catalog_item_template}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('key, name, input_type', 'required'),
            array('key', 'length', 'max' => 32),
            array('name', 'length', 'max' => 50),
            // The following rule is used by search().
            array('id, key, name, input_type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Returns a list of behaviors that this model should behave as.
     * @return array the behavior configurations (behavior name=>behavior configuration)
     */
    public function behaviors()
    {
        return array(
            'statusInputType' => array(
                'class'     => 'application.components.behaviors.StatusBehavior',
                'attribute' => 'input_type',
                'list'      => array(
                    Yii::t('CatalogModule.catalog', 'Text'),
                    Yii::t('CatalogModule.catalog', 'Textarea'),
                    Yii::t('CatalogModule.catalog', 'File'),
                    Yii::t('CatalogModule.catalog', 'Image')
                )
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'items' => array(self::MANY_MANY, 'CatalogItem', '{{catalog_item_data}}(key, item_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'         => 'ID',
            'key'        => Yii::t('CatalogModule.catalog', 'Key'),
            'name'       => Yii::t('CatalogModule.catalog', 'Name'),
            'input_type' => Yii::t('CatalogModule.catalog', 'Input Type'),
        );
    }

    public function afterFind()
    {
       $this->oldKey = $this->key;
        parent::afterFind();
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            $this->getDbConnection()->createCommand('SET foreign_key_checks = 0;')->execute();
            return true;
        } else {
            return false;
        }
    }

    public function afterSave()
    {
        $catalogItemData = CatalogItemData::model()->findAllByAttributes(array('key' => $this->oldKey));
        if ($catalogItemData) {
            foreach ($catalogItemData as $data) {
                /** @var CatalogItemData $data */
                $data->setAttribute('key', $this->key);
                $data->save(false);
            }
            $this->getDbConnection()->createCommand('SET foreign_key_checks = 1;')->execute();
        }
        Yii::app()->getCache()->delete(__CLASS__ . 'names');
        parent::afterSave();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
		$criteria->compare('key', $this->key, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('input_type', $this->input_type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getFormMethod($inputType = 0)
    {
        switch ($inputType) {
            case self::INPUT_TYPE_TEXT:
                return 'textField';
            case self::INPUT_TYPE_TEXTAREA:
                return 'textArea';
            case self::INPUT_TYPE_FILE:
            case self::INPUT_TYPE_IMAGE:
            return array(
                'name'       => 'ext.elFinder.ElFinderWidget',
                'properties' => array('connectorRoute' => '/elfinder/connector/')
            );
            default:
                return 'textField';
        }
    }

    /**
     * @param string $key
     * @return string
     */
    public static function getName($key = '')
    {
        $cacheKey = __CLASS__ . 'names';
        if (!empty($key)) {
            if (!$data = Yii::app()->getCache()->get($cacheKey)) {
                $dataReader = Yii::app()->getDb()->createCommand()->select()->from(self::tableName())->query();
                foreach ($dataReader as $row) {
                    $data[$row['key']] = $row['name'];
                }
                Yii::app()->getCache()->set($cacheKey, $data);
            }
            return isset($data[$key]) ? $data[$key] : $key . ' ' . Yii::t('zii', 'Not set');
        }
        return Yii::t('zii', 'Your request is invalid.');
    }
}

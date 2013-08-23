<?php

/**
 * This is the model class for table "{{good_data}}".
 *
 * The followings are the available columns in table '{{good_data}}':
 * @property integer $good_id
 * @property string $key
 * @property string $value
 */
class GoodData extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return GoodData the static model class
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
        return '{{good_data}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('good_id, key, value', 'required'),
            array('good_id', 'numerical', 'integerOnly' => true),
            array('key', 'length', 'max' => 32),
            array('value', 'length', 'max' => 500),
            // The following rule is used by search().
            array('good_id, key, value', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'good_id' => Yii::t('CatalogModule.catalog', 'Good'),
            'key'     => Yii::t('CatalogModule.catalog', 'Key'),
            'value'   => Yii::t('CatalogModule.catalog', 'Value'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

		$criteria->compare('good_id', $this->good_id);
		$criteria->compare('key', $this->key,true);
		$criteria->compare('value', $this->value,true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}

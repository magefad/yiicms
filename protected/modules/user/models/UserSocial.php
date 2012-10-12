<?php

/**
 * This is the model class for table "{{user_social}}".
 *
 * The followings are the available columns in table '{{user_social}}':
 * @property string $id
 * @property integer $user_id
 * @property string $service
 * @property string $access_token
 * @property string $email
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserSocial extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserSocial the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user_social}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('id, user_id, service', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('email', 'email'),
            array('id, access_token', 'length', 'max' => 255),
            array('service', 'length', 'max' => 64),

            array('id', 'unique', 'message' => Yii::t('user', 'Identity is invalid or already taken')),
            array('id, user_id, service, access_token', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'             => Yii::t('user', 'ID'),
            'user_id'        => Yii::t('user', 'User'),
            'service'        => Yii::t('user', 'Service'),
            'access_token'   => Yii::t('user', 'access_token'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('service', $this->service, true);
        $criteria->compare('access_token', $this->access_token, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $service
     * @param integer $id
     * @return UserSocial
     */
    public function findByServiceId($id, $service='vkontakte')
    {
        return $this->find('service=:service AND id=:id', array('service' => $service, 'id' => $id));
    }
}

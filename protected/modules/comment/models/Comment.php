<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property integer $id
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property string $model
 * @property integer $model_id
 * @property string $create_time
 * @property string $update_time
 * @property string $text
 * @property integer $status
 * @property string $ip
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Comment extends CActiveRecord
{
    const STATUS_NOT_APPROVED = 0;
    const STATUS_APPROVED     = 1;
    const STATUS_SPAM         = 2;
    const STATUS_DELETED      = 3;

    public $verifyCode;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Comment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return CommentModule the comment module instance
     */
    public function getModule()
    {
        return Yii::app()->getModule('comment');
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{comment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('model, model_id, text', 'required'),
            array('status, create_user_id, update_user_id, model_id', 'numerical', 'integerOnly' => true),
            array('model', 'length', 'max' => 16),
            array('ip', 'length', 'max' => 20),
            array('model, text', 'filter', 'filter' => 'trim'),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('model, text', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements() || !Yii::app()->user->isGuest),
            array('id, create_user_id, update_user_id, model, model_id, create_time, update_time, text, status, ip', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'create_user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => 'ID',
            'create_user_id'     => Yii::t('CommentModule.comment', 'User'),
            'update_user_id'  => Yii::t('CommentModule.comment', 'Change User'),
            'model'       => Yii::t('CommentModule.comment', 'Model'),
            'model_id'    => Yii::t('CommentModule.comment', 'Model'),
            'create_time' => Yii::t('CommentModule.comment', 'Create Time'),
            'update_time' => Yii::t('CommentModule.comment', 'Update Time'),
            'text'        => Yii::t('CommentModule.comment', 'Comment Text'),
            'status'      => Yii::t('CommentModule.comment', 'Status'),
            'ip'          => 'IP',
        );
    }

    public function scopes()
    {
        return array(
            'new'      => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_NOT_APPROVED),
            ),
            'approved' => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_APPROVED),
                'order'     => 'create_time DESC',
            ),
            'authored' => array(
                'condition' => 'create_user_id is not null',
            ),
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
        $criteria->compare('create_user_id', $this->create_user_id, true);
        $criteria->compare('update_user_id', $this->update_user_id, true);
        $criteria->compare('model', $this->model, true);
        $criteria->compare('model_id', $this->model_id, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('ip', $this->ip, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave()
    {
        $this->update_user_id = Yii::app()->user->id;
        unset($this->update_time);//on update CURRENT_TIMESTAMP
        if ($this->isNewRecord) {
            $this->create_time  = new CDbExpression('now()');
            $this->create_user_id = $this->update_user_id;
            $this->ip = Yii::app()->request->userHostAddress;
        }
        return parent::beforeSave();
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_APPROVED     => Yii::t('CommentModule.comment', 'Approved'),
            self::STATUS_DELETED      => Yii::t('CommentModule.comment', 'Deleted'),
            self::STATUS_NOT_APPROVED => Yii::t('CommentModule.comment', 'Not approved'),
            self::STATUS_SPAM         => Yii::t('CommentModule.comment', 'Spam'),
        );
    }

    public function getStatus()
    {
        $list = $this->getStatusList();
        return isset($list[$this->status]) ? $list[$this->status] : Yii::t('CommentModule.comment', 'Unknown status');
    }

    /**
     * @return string get comment users name
     */
    public function getUsername()
    {
        return is_null($this->user) ? Yii::t('CommentModule.comment', 'Guest') : $this->user->{$this->module->usernameAttribute};
    }

    /**
     * @return string get comment users email
     */
    public function getUserEmail()
    {
        return is_null($this->user) ? 'nobody@example.com' : $this->user->{$this->module->userEmailAttribute};
    }
}

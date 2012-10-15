<?php

/**
 * This is the model class for table "{{user_blog}}".
 *
 * The followings are the available columns in table '{{user_blog}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $blog_id
 * @property integer $role
 * @property integer $status
 * @property string $note
 * @property integer $create_time
 * @property integer $update_time
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Blog $blog
 */
class UserBlog extends CActiveRecord
{
    const ROLE_USER      = 1;
    const ROLE_MODERATOR = 2;
    const ROLE_ADMIN     = 3;

    const STATUS_ACTIVE = 1;
    const STATUS_BLOCK  = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserBlog the static model class
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
        return '{{user_blog}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('user_id, blog_id', 'required', 'except' => 'search'),
            array('role, status, user_id, blog_id', 'numerical', 'integerOnly'=> true),
            array('user_id, blog_id, create_time, update_time', 'length', 'max'=> 10),
            array('note', 'length', 'max'=> 255),
            array('role', 'in', 'range' => array_keys($this->getRoleList())),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('note', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('id, user_id, blog_id, role, status, note, create_time, update_time', 'safe', 'on'=> 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'blog' => array(self::BELONGS_TO, 'Blog', 'blog_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('BlogModule.blog', 'ID'),
            'user_id'     => Yii::t('BlogModule.blog', 'User'),
            'blog_id'     => Yii::t('BlogModule.blog', 'Blog'),
            'role'        => Yii::t('BlogModule.blog', 'Role'),
            'status'      => Yii::t('BlogModule.blog', 'Status'),
            'note'        => Yii::t('BlogModule.blog', 'Note'),
            'create_time' => Yii::t('BlogModule.blog', 'Create Time'),
            'update_time' => Yii::t('BlogModule.blog', 'Update Time'),
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
        $criteria->compare('blog_id', $this->blog_id, true);
        $criteria->compare('role', $this->role);
        $criteria->compare('status', $this->status);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->with = array('user', 'blog');
        return new CActiveDataProvider($this, array(
            'criteria'=> $criteria,
        ));
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            $this->update_time = time();
            if ($this->isNewRecord) {
                $this->create_time = $this->update_time;
            }
            return true;
        } else {
            return false;
        }
    }

    public function getRoleList()
    {
        return array(
            self::ROLE_USER      => Yii::t('BlogModule.blog', 'Member'),
            self::ROLE_MODERATOR => Yii::t('BlogModule.blog', 'Moderator'),
            self::ROLE_ADMIN     => Yii::t('BlogModule.blog', 'Administrator'),
        );
    }

    public function getRole()
    {
        $data = $this->getRoleList();
        return isset($data[$this->role]) ? $data[$this->role] : Yii::t('BlogModule.blog', 'unknown');
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE => Yii::t('BlogModule.blog', 'Active'),
            self::STATUS_BLOCK  => Yii::t('BlogModule.blog', 'Blocked'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('BlogModule.blog', 'unknown');
    }
}

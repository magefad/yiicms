<?php

/**
 * This is the model class for table "{{blog}}".
 *
 * The followings are the available columns in table '{{blog}}':
 * @property integer $id
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $slug
 * @property integer $type
 * @property string $status
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $create_time
 * @property integer $update_time
 *
 * The followings are the available model relations:
 * @property User $createUser
 * @property User $updateUser
 *
 * The followings are the available model behaviors:
 * @property StatusBehavior $statusMain
 * @property StatusBehavior $statusType
 */
class Blog extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Blog the static model class
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
        return '{{blog}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('title, description', 'required', 'except' => 'search'),
            array('create_user_id, update_user_id', 'numerical', 'integerOnly' => true),
            array('title, keywords, slug', 'length', 'max' => 200),
            array('type', 'in', 'range' => array_keys($this->statusType->getList())),
            array('status', 'in', 'range' => array_keys($this->statusMain->getList())),
            array('title, keywords, slug, description', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array(
                'slug',
                'match',
                'pattern' => '/^[a-zA-Z0-9_\-]+$/',
                'message' => Yii::t('BlogModule.blog', 'String contains illegal characters. Allowed: {attribute}')
            ),
            array('slug', 'unique'),
            array(
                'id, title, keywords, description, slug, type, status, create_user_id, update_user_id, create_time, update_time',
                'safe',
                'on' => 'search'
            ),
        );
    }

    /**
     * Returns a list of behaviors that this model should behave as.
     * @return array the behavior configurations (behavior name=>behavior configuration)
     */
    public function behaviors()
    {
        return array(
            'SaveBehavior' => array(
                'class' => 'application.modules.admin.behaviors.SaveBehavior',
            ),
            'statusMain' => array(
                'class' => 'application.modules.admin.behaviors.StatusBehavior',
                'list'  => array(
                    'active'  => Yii::t('BlogModule.blog', 'Active'),
                    'blocked' => Yii::t('BlogModule.blog', 'Blocked'),
                    'deleted' => Yii::t('BlogModule.blog', 'Deleted'),
                )
            ),
            'statusType' => array(
                'class'     => 'application.modules.admin.behaviors.StatusBehavior',
                'attribute' => 'type',
                'list'      => array(
                    'public'  => Yii::t('BlogModule.blog', 'Public'),
                    'private' => Yii::t('BlogModule.blog', 'Private')
                )
            )
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'createUser'   => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'updateUser'   => array(self::BELONGS_TO, 'User', 'update_user_id'),
            'posts'        => array(self::HAS_MANY, 'Post', 'blog_id'),
            'userBlog'     => array(self::HAS_MANY, 'UserBlog', 'blog_id'),
            'members'      => array(self::HAS_MANY, 'User', array('user_id' => 'id'), 'through' => 'userBlog'),
            'postsCount'   => array(
                self::STAT,
                'Post',
                'blog_id',
                'condition' => 'status = "published"'
            ),
            'membersCount' => array(
                self::STAT,
                'UserBlog',
                'blog_id',
                'condition' => 'status = :status',
                'params'    => array(':status' => UserBlog::STATUS_ACTIVE)
            ),
        );
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'status = "active"'
            ),
            'public'    => array(
                'condition' => 'type = "public"'
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'             => Yii::t('BlogModule.blog', 'ID'),
            'title'          => Yii::t('BlogModule.blog', 'Title'),
            'keywords'       => Yii::t('BlogModule.blog', 'Keywords'),
            'description'    => Yii::t('BlogModule.blog', 'Description'),
            'slug'           => Yii::t('BlogModule.blog', 'URL'),
            'type'           => Yii::t('BlogModule.blog', 'Type'),
            'status'         => Yii::t('BlogModule.blog', 'Status'),
            'create_user_id' => Yii::t('BlogModule.blog', 'Author'),
            'update_user_id' => Yii::t('BlogModule.blog', 'Changed'),
            'create_time'    => Yii::t('BlogModule.blog', 'Create Time'),
            'update_time'    => Yii::t('BlogModule.blog', 'Update Time'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_user_id', $this->create_user_id, true);
        $criteria->compare('update_user_id', $this->update_user_id, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->with = array('createUser', 'updateUser');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Join user in blog
     * Add record to table user_blog
     * @param integer $userId
     * @return bool
     */
    public function join($userId = 0)
    {
        $userId = (int)$userId ? (int)$userId : Yii::app()->user->getId();
        $userBlog = new UserBlog;

        if (!$userBlog->find(
            'user_id = :user_id AND blog_id = :blog_id',
            array(
                'user_id' => $userId,
                'blog_id' => $this->id,
            )
        )
        ) {
            $userBlog->setAttributes(
                array(
                    'user_id' => $userId,
                    'blog_id' => $this->id,
                )
            );
            return $userBlog->save();
        }
        return false;
    }

    /**
     * Get all users joined in Blog
     * @return array UserBlog
     */
    public function getMembers()
    {
        return UserBlog::model()->with('user')->findAll('blog_id = :blog_id', array(':blog_id' => $this->id));
    }
}

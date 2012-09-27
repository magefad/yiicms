<?php

/**
 * This is the model class for table "{{blog_post}}".
 *
 * The followings are the available columns in table '{{blog_post}}':
 * @property integer $id
 * @property integer $blog_id
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $publish_time
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $keywords
 * @property string $description
 * @property string $link
 * @property integer $status
 * @property integer $comment_status
 * @property integer $access_type
 *
 * The followings are the available model relations:
 * @property User $createUser
 * @property User $updateUser
 * @property Blog $blog
 *
 * @method getTags() return array Post Tags
 */
class Post extends CActiveRecord
{
    const STATUS_DRAFT     = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_SCHEDULED = 2;

    const ACCESS_PUBLIC  = 1;
    const ACCESS_PRIVATE = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Post the static model class
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
        return '{{blog_post}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('blog_id, publish_time, title, content', 'required', 'except' => 'search'),
            array(
                'blog_id, create_user_id, update_user_id, status, comment_status, access_type',
                'numerical',
                'integerOnly' => true
            ),
            array('blog_id, create_user_id, update_user_id', 'length', 'max' => 10),
            array('create_time, update_time, publish_time', 'length', 'max' => 11),
            array('title, slug, keywords, link', 'length', 'max' => 128),
            array('description', 'length', 'max' => 255),
            array('link', 'url'),
            array('comment_status', 'in', 'range' => array(0, 1)),
            array('access_type', 'in', 'range' => array_keys($this->getAccessTypeList())),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('slug', 'unique'),
            array(
                'title, slug, link, keywords, description, publish_time',
                'filter',
                'filter' => array($obj = new CHtmlPurifier(), 'purify')
            ),
            array(
                'id, blog_id, create_user_id, update_user_id, create_time, update_time, publish_time, title, slug, content, keywords, description, link, status, comment_status, access_type',
                'safe',
                'on' => 'search'
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
            'blog'       => array(self::BELONGS_TO, 'Blog', 'blog_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'             => Yii::t('blog', 'ID'),
            'blog_id'        => Yii::t('blog', 'Blog'),
            'create_user_id' => Yii::t('blog', 'Author'),
            'update_user_id' => Yii::t('blog', 'Changed'),
            'create_time'    => Yii::t('blog', 'Create Time'),
            'update_time'    => Yii::t('blog', 'Update Time'),
            'publish_time'   => Yii::t('blog', 'Publish Time'),
            'title'          => Yii::t('blog', 'Title'),
            'slug'           => Yii::t('blog', 'URL'),
            'content'        => Yii::t('blog', 'Content'),
            'tags'           => Yii::t('blog', 'Tags'),
            'keywords'       => Yii::t('blog', 'Keywords'),
            'description'    => Yii::t('blog', 'Description'),
            'link'           => Yii::t('blog', 'Link'),
            'status'         => Yii::t('blog', 'Status'),
            'comment_status' => Yii::t('blog', 'Comment Status'),
            'access_type'    => Yii::t('blog', 'Access Type'),
        );
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 't.status = :status',
                'params'    => array(':status' => self::STATUS_PUBLISHED),
            ),
            'public'    => array(
                'condition' => 't.access_type = :access_type',
                'params'    => array(':access_type' => self::ACCESS_PUBLIC),
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
        $criteria->compare('blog_id', $this->blog_id, true);
        $criteria->compare('create_user_id', $this->create_user_id, true);
        $criteria->compare('update_user_id', $this->update_user_id, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('publish_time', $this->publish_time, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('link', $this->link, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('comment_status', $this->comment_status);
        $criteria->compare('access_type', $this->access_type);
        $criteria->with = array('createUser', 'updateUser', 'blog');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function afterFind()
    {
        $this->publish_time = date('d-m-Y', $this->publish_time);
        parent::afterFind();
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            $this->publish_time   = strtotime($this->publish_time . date(' H:m:s'));
            $this->update_time    = time();
            $this->update_user_id = Yii::app()->user->getId();
            if ($this->isNewRecord) {
                $this->create_time    = $this->update_time;
                $this->create_user_id = $this->update_user_id;
            }
            return true;
        } else {
            return false;
        }
    }

    public function beforeValidate()
    {
        if (!$this->slug) {
            $this->slug = Text::translit($this->title);
        }
        return parent::beforeValidate();
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_SCHEDULED  => Yii::t('blog', 'Scheduled'),
            self::STATUS_DRAFT      => Yii::t('blog', 'Draft'),
            self::STATUS_PUBLISHED  => Yii::t('blog', 'Published'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('blog', 'unknown');
    }

    public function getAccessTypeList()
    {
        return array(
            self::ACCESS_PRIVATE => Yii::t('blog', 'Private'),
            self::ACCESS_PUBLIC  => Yii::t('blog', 'Public')
        );
    }

    public function getAccessType()
    {
        $data = $this->getAccessTypeList();
        return isset($data[$this->access_type]) ? $data[$this->access_type] : Yii::t('blog', 'unknown');
    }

    public function getCommentStatus()
    {
        return $this->comment_status ? Yii::t('blog', 'Yes') : Yii::t('blog', 'No');
    }

    public function behaviors()
    {
        return array(
            'tags' => array(
                'class'                => 'blog.extensions.taggable.ETaggableBehavior',
                'tagTable'             => Yii::app()->db->tablePrefix . 'tag',
                'tagBindingTable'      => Yii::app()->db->tablePrefix . 'blog_post_tag',
                'modelTableFk'         => 'post_id',
                'tagBindingTableTagId' => 'tag_id',
                'cacheID'              => 'cache',
            ),
        );
    }
}

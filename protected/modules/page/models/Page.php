<?php

/**
 * This is the model class for table "{{page}}".
 *
 * The followings are the available columns in table '{{page}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $content
 * @property string $slug
 * @property integer $status
 * @property integer $is_protected
 * @property integer $menu_order
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Page $children
 * @property Page $parent
 * @property User $author
 * @property User $changeAuthor
 */
class Page extends CActiveRecord
{
    public $author_search;
    public $changeAuthor_search;

    const STATUS_DRAFT      = 0;
    const STATUS_PUBLISHED  = 1;
    const STATUS_MODERATION = 2;

    const PROTECTED_NO  = 0;
    const PROTECTED_YES = 1;

    const ROOT_YES = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Page the static model class
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
        return '{{page}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, title, content, status, is_protected', 'required'),
            array('parent_id, status, is_protected, menu_order, create_user_id, update_user_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            array('title, keywords, slug', 'length', 'max' => 200),
            array('description', 'length', 'max' => 250),
            array('slug', 'unique'), #sulug is a link of page
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('is_protected', 'in', 'range' => array_keys($this->getProtectedStatusList())),
            array('name, title, keywords, description, content, slug', 'filter', 'filter' => 'trim'),
            array(
                'title, slug, description, keywords, name',
                'filter',
                'filter' => array($obj = new CHtmlPurifier(), 'purify')
            ),
            array(
                'slug',
                'match',
                'pattern' => '/^[a-zA-Z0-9_\-]+$/',
                'message' => Yii::t('page', 'Строка содержит запрещенные символы: {attribute}')
            ),
            array(
                'id, parent_id, name, title, keywords, description, slug, content, status, menu_order, create_time, update_time, author_search, changeAuthor_search',
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
            'children'     => array(self::HAS_MANY, 'Page', 'parent_id', 'order' => 'menu_order ASC'),
            'parent'       => array(self::BELONGS_TO, 'Page', 'parent_id'),
            'author'       => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'changeAuthor' => array(self::BELONGS_TO, 'User', 'update_user_id'),
        );
    }

    /**
     * @return array
     */
    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'status = :status',
                'params'    => array('status' => self::STATUS_PUBLISHED)
            ),
            'protected' => array(
                'condition' => 'is_protected = :is_protected',
                'params'    => array(':is_protected' => self::PROTECTED_YES)
            ),
            'public'    => array(
                'condition' => 'is_protected = :is_protected',
                'params'    => array(':is_protected' => self::PROTECTED_NO)
            ),
            'root'      => array(
                'condition' => 'parent_id = :parent_id',
                'params'    => array(':parent_id' => self::ROOT_YES)
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                  => Yii::t('page', 'ID'),
            'parent_id'           => Yii::t('page', 'Родитель'),
            'name'                => Yii::t('page', 'Название в меню'),
            'title'               => Yii::t('page', 'Заголовок (Seo title)'),
            'keywords'            => Yii::t('page', 'Ключевые слова (Seo keywords)'),
            'description'         => Yii::t('page', 'Описание (Seo description)'),
            'content'             => Yii::t('page', 'Текст'),
            'slug'                => Yii::t('page', 'Ссылка'),
            'status'              => Yii::t('page', 'Статус'),
            'is_protected'        => Yii::t('page', 'Доступ только для авторизованных пользователей'),
            'menu_order'          => Yii::t('page', 'Порядок'),
            'create_user_id'      => Yii::t('page', 'Создал'),
            'update_user_id'      => Yii::t('page', 'Изменил'),
            'create_time'         => Yii::t('page', 'Создано'),
            'update_time'         => Yii::t('page', 'Изменено'),
            'author_search'       => Yii::t('page', 'Создал'),
            'changeAuthor_search' => Yii::t('page', 'Изменил'),
        );
    }

    /**
     * If slug (link) is empty, translit title to slug (link)
     * @return bool
     */
    public function beforeValidate()
    {
        if (!$this->slug) {
            $this->slug = Text::translit($this->title);
        }
        return parent::beforeValidate();
    }


    public function beforeSave()
    {
        $this->update_user_id = Yii::app()->user->getId();
        unset($this->update_time);//on update CURRENT_TIMESTAMP
        if ($this->isNewRecord) {
            $this->create_time  = new CDbExpression('now()');
            $this->create_user_id = $this->update_user_id;
        }
        return parent::beforeSave();
    }

    /**
     * @param $slug
     * @return CActiveRecord
     */
    public function findBySlug($slug)
    {
        return $this->find('slug = :slug', array(':slug' => trim($slug)));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria       = new CDbCriteria;
        $criteria->with = array('author', 'changeAuthor');

        $criteria->compare('id', $this->id, true);
        $criteria->compare('parent_id', $this->parent_id);

        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('slug', $this->slug, true);


        $criteria->compare('t.status', $this->status);
        $criteria->compare('is_protected', $this->is_protected);
        $criteria->compare('menu_order', $this->menu_order);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('author.username', $this->author_search, true);
        $criteria->compare('changeAuthor.username', $this->changeAuthor_search, true);

        $sort               = new CSort;
        $sort->defaultOrder = 't.menu_order ASC';
        $sort->attributes   = array(
            'author_search'       => array(
                'asc' => 'author.username',
                'desc' => 'author.username DESC',
            ),
            'changeAuthor_search' => array(
                'asc' => 'changeAuthor.username',
                'desc' => 'changeAuthor.username DESC',
            ),
            '*',
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'     => $sort
        ));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_PUBLISHED  => Yii::t('page', 'Опубликовано'),
            self::STATUS_DRAFT      => Yii::t('page', 'Черновик'),
            self::STATUS_MODERATION => Yii::t('page', 'На модерации')
        );
    }

    /**
     * Get status of page
     * @return string
     */
    public function getStatus()
    {
        $data = $this->getStatusList();
        return array_key_exists($this->status, $data) ? $data[$this->status] : Yii::t('page', 'неизвестно');
    }


    public function getProtectedStatusList()
    {
        return array(
            self::PROTECTED_NO  => Yii::t('page', 'нет'),
            self::PROTECTED_YES => Yii::t('page', 'да')
        );
    }

    /**
     * Page enabled oto view on site or no
     * @return string
     */
    public function getProtectedStatus()
    {
        $data = $this->getProtectedStatusList();
        return array_key_exists($this->is_protected, $data) ? $data[$this->is_protected] : Yii::t('page', 'неизвестно');
    }

    /**
     *
     * @return array
     */
    public function getAllPagesList()
    {
        $parents = $this->findAll(
            array(
                'select'    => 'id, title, name',
                'condition' => 'parent_id is null OR parent_id=0',
                'order'     => 'menu_order'
            )
        );
        $tree    = new Tree();
        return $tree->makeDropDown($parents);
    }

    /**
     * @return string parent name
     */
    public function getParentName()
    {
        return is_null($this->parent) ? '---' : $this->parent->name;
    }
}

<?php

/**
 * This is the model class for table "{{page}}".
 *
 * The followings are the available columns in table '{{page}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $level
 * @property string $name
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $content
 * @property string $slug
 * @property integer $rich_editor
 * @property string $status
 * @property boolean $is_protected
 * @property integer $sort_order
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
 *
 * The followings are the available model behaviors:
 * @property StatusBehavior $statusMain
 * @property StatusBehavior $statusProtected
 *
 * @method published()
 * @method protected()
 * @method public()
 * @method root()
 */
class Page extends CActiveRecord
{
    public $author_search;
    public $changeAuthor_search;

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
            array('name, title, description, content, status', 'required'),
            array('parent_id, level, rich_editor, sort_order, create_user_id, update_user_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            array('title, slug', 'length', 'max' => 75),
            array('keywords, description', 'length', 'max' => 200),
            array('slug', 'unique'), #slug is a link of page
            array('status', 'in', 'range' => array_keys($this->statusMain->getList())),
            array('is_protected', 'boolean'),
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
                'id, parent_id, level, name, title, keywords, description, slug, content, status, sort_order, create_time, update_time, author_search, changeAuthor_search',
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
                'class' => 'application.components.behaviors.SaveBehavior',
            ),
            'syncTranslit' => array(
                'class' => 'ext.syncTranslit.SyncTranslitBehavior',
            ),
            'treeArray' => array(
                'class' => 'application.components.behaviors.AdjacencyListBehavior',
                'textAttribute' => 'name'
            ),
            'sortable' => array(
                'class' => 'application.components.behaviors.SortableBehavior',
            ),
            'statusMain' => array(
                'class' => 'application.components.behaviors.StatusBehavior'
            ),
            'statusProtected' => array(
                'class'     => 'application.components.behaviors.StatusBehavior',
                'attribute' => 'is_protected',
                'list'      => array(
                    Yii::t('page', 'Нет'),
                    Yii::t('page', 'Да')
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
            'children'     => array(self::HAS_MANY, 'Page', 'parent_id', 'order' => 'sort_order ASC'),
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
                'condition' => 'status = 1',
            ),
            'protected' => array(
                'condition' => 'is_protected = 1',
            ),
            'public'    => array(
                'condition' => 'is_protected = 0',
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
            'level'               => Yii::t('page', 'Уровень вложенности'),
            'name'                => Yii::t('page', 'Название в меню'),
            'title'               => Yii::t('page', 'Заголовок (title)'),
            'keywords'            => Yii::t('page', 'META ключевые слова'),
            'description'         => Yii::t('page', 'META описание'),
            'content'             => Yii::t('page', 'Текст'),
            'slug'                => Yii::t('page', 'Ссылка'),
            'rich_editor'         => Yii::t('page', 'Использовать HTML редактор'),
            'status'              => Yii::t('page', 'Статус'),
            'is_protected'        => Yii::t('page', 'Доступ только для авторизованных пользователей'),
            'sort_order'          => Yii::t('page', 'Порядок'),
            'create_user_id'      => Yii::t('page', 'Создал'),
            'update_user_id'      => Yii::t('page', 'Изменил'),
            'create_time'         => Yii::t('page', 'Создано'),
            'update_time'         => Yii::t('page', 'Изменено'),
            'author_search'       => Yii::t('page', 'Создал'),
            'changeAuthor_search' => Yii::t('page', 'Изменил'),
        );
    }

    /**
     * @param string $slug
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
        $criteria->compare('level', $this->level);

        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('rich_editor', $this->rich_editor, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('is_protected', $this->is_protected);
        $criteria->compare('sort_order', $this->sort_order);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('author.username', $this->author_search, true);
        $criteria->compare('changeAuthor.username', $this->changeAuthor_search, true);

        $sort               = new CSort;
        $sort->defaultOrder = 't.sort_order ASC';
        $sort->attributes   = array(
            'author_search'       => array(
                'asc'  => 'author.username',
                'desc' => 'author.username DESC',
            ),
            'changeAuthor_search' => array(
                'asc'  => 'changeAuthor.username',
                'desc' => 'changeAuthor.username DESC',
            ),
            '*',
        );

        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'pagination' => array('pageSize' => Yii::app()->getModule('page')->pageSize),
            'sort'       => $sort
        ));
    }
}

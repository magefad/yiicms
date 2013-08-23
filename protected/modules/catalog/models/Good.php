<?php
Yii::import('page.models.Page');
/**
 * This is the model class for table "{{good}}".
 *
 * The followings are the available columns in table '{{good}}':
 * @property integer $id
 * @property integer $page_id
 * @property string $name
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $slug
 * @property integer $status
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property StatusBehavior $statusMain
 * @property Page $page
 * @property User $createUser
 * @property GoodTemplate[] $templates
 * @property GoodData[] $data
 *
 * @method published()
 */
class Good extends CActiveRecord
{
    /**
     * @var array key=>value
     */
    private $_data = array();
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Good the static model class
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
        return '{{good}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('page_id, name, title, slug', 'required'),
            array('page_id, status, create_user_id, update_user_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            array('title, slug', 'length', 'max' => 75),
            array('keywords, description', 'length', 'max' => 200),
            array('create_time', 'safe'),
            // The following rule is used by search().
            array('id, page_id, name, title, keywords, description, slug, status, create_user_id, update_user_id, create_time, update_time', 'safe', 'on' => 'search'),
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
            'statusMain' => array(
                'class' => 'application.components.behaviors.StatusBehavior'
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
            'page'       => array(self::BELONGS_TO, 'Page', 'page_id'),
            'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'templates'  => array(self::MANY_MANY, 'GoodTemplate', '{{good_data}}(good_id, key)'),
            'data'       => array(self::HAS_MANY, 'GoodData', 'good_id')
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'             => 'ID',
            'page_id'        => Yii::t('CatalogModule.catalog', 'Page'),
            'name'           => Yii::t('CatalogModule.catalog', 'Name'),
            'title'          => Yii::t('CatalogModule.catalog', 'Title'),
            'keywords'       => Yii::t('CatalogModule.catalog', 'Keywords'),
            'description'    => Yii::t('CatalogModule.catalog', 'Description'),
            'slug'           => Yii::t('CatalogModule.catalog', 'Slug'),
            'status'         => Yii::t('CatalogModule.catalog', 'Status'),
            'create_user_id' => Yii::t('CatalogModule.catalog', 'Create User'),
            'update_user_id' => Yii::t('CatalogModule.catalog', 'Update User'),
            'create_time'    => Yii::t('CatalogModule.catalog', 'Create Time'),
            'update_time'    => Yii::t('CatalogModule.catalog', 'Update Time'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('page' => array('select' => 'id, name'), 'data');
		$criteria->compare('id', $this->id);
		$criteria->compare('page_id', $this->page_id);
		$criteria->compare('name', $this->name,true);
		$criteria->compare('title', $this->title,true);
		$criteria->compare('keywords', $this->keywords,true);
		$criteria->compare('description', $this->description,true);
		$criteria->compare('slug', $this->slug,true);
		$criteria->compare('status', $this->status);
		$criteria->compare('create_user_id', $this->create_user_id);
		$criteria->compare('update_user_id', $this->update_user_id);
		$criteria->compare('create_time', $this->create_time,true);
		$criteria->compare('update_time', $this->update_time,true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $key template
     * @return string value by template key
     */
    public function getValue($key = '')
    {
        if (!empty($key) && !$this->getIsNewRecord()) {
            if (empty($this->_data)) {
                foreach ($this->data as $data) {
                    $this->_data[$data->key] = $data->value;
                }
            }
            return isset($this->_data[$key]) ? $this->_data[$key] : $key . ' ' . Yii::t('zii', 'Not set');
        }
        return Yii::t('zii', 'Your request is invalid.');
    }
}

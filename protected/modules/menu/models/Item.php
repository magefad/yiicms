<?php

/**
 * This is the model class for table "{{menu_item}}".
 *
 * The followings are the available columns in table '{{menu_item}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $menu_id
 * @property string $title
 * @property string $href
 * @property integer $type
 * @property string $access
 * @property integer $status
 * @property integer $sort_order
 *
 * The followings are the available model relations:
 * @property Item $children
 * @property Item $parent
 * @property Menu $menu
 */
class Item extends CActiveRecord
{
    const STATUS_ACTIVE   = 1;
    const STATUS_DISABLED = 0;

    public $menu_search;
    public $parent_search;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Item the static model class
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
        return '{{menu_item}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('menu_id, title, href', 'required'),
            array('parent_id, menu_id, type, status, sort_order', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 100),
            array('href, access', 'length', 'max' => 200),
            array('access', 'length', 'max' => 50),
            array(
                'id, parent_id, menu_id, title, href, type, access, status, sort_order,  menu_search, parent_search',
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
            'children' => array(self::HAS_MANY, 'Item', 'parent_id' /*, 'order' => 'sort_order ASC'*/),
            'parent'   => array(self::BELONGS_TO, 'Item', 'parent_id'),
            'menu'     => array(self::BELONGS_TO, 'Menu', 'menu_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('menu', 'ID'),
            'parent_id'     => Yii::t('menu', 'Родитель'),
            'menu_id'       => Yii::t('menu', 'Меню'),
            'title'         => Yii::t('menu', 'Заголовок'),
            'href'          => Yii::t('menu', 'Ссылка'),
            'access'        => Yii::t('menu', 'Уровень доступа'),
            'status'        => Yii::t('menu', 'Статус'),
            'sort_order'    => Yii::t('menu', 'Порядок'),
            'menu_search'   => Yii::t('menu', 'Меню'),
            'parent_search' => Yii::t('menu', 'Родитель'),
        );
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            Yii::app()->cache->delete('menu_' . $this->menu->code);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria       = new CDbCriteria;
        $criteria->with = array('menu', 'parent');

        $criteria->compare('id', $this->id, true);
        $criteria->compare('parent_id', $this->parent_id, true); //@todo выключить?
        #$criteria->compare('menu_id', $this->menu_id, true);
        $criteria->compare('menu.name', $this->menu_search, true);
        $criteria->compare('parent.title', $this->parent_search, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('href', $this->href, true);
        //$criteria->compare('type', $this->type);
        $criteria->compare('t.access', $this->access, true);
        $criteria->compare('sort_order', $this->sort_order);
        $criteria->compare('t.status', $this->status);

        $sort               = new CSort;
        $sort->defaultOrder = 't.sort_order';
        $sort->attributes   = array(
            'menu_search'   => array(
                'asc' => 'menu.name',
                'desc' => 'menu.name DESC',
            ),
            'parent_search' => array(
                'asc' => 'parent.title',
                'desc' => 'parent.title DESC',
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
            self::STATUS_DISABLED => Yii::t('menu', 'не активно'),
            self::STATUS_ACTIVE   => Yii::t('menu', 'активно'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('menu', 'неизвестно');
    }

    public function getParentList()
    {
        /** @var $parents Item[] */
        $parents = Item::model()->findAll(
            array(
                'select'     => 'id, title',
                'condition'  => 'parent_id is null OR parent_id=0',
                'order'      => 'sort_order'
            )
        );
        // add parent_id = 0 (Root)
        $parents['0'] = Item::model();
        $parents['0']->setAttribute('id', 0);
        $parents['0']->setAttribute('title', Yii::t('menu', 'Корень меню'));

        $tree       = new Tree();
        $tree->name = 'title';
        return $tree->makeDropDown($parents);
    }

    public function getParent()
    {
        $data = $this->parentList;
        return isset($data[$this->parent_id]) ? $data[$this->parent_id] : Yii::t('menu', 'неизвестно');
    }

    public function getAccessList()
    {
        Yii::import("application.modules.rights.components.dataproviders.RAuthItemDataProvider");
        $all_roles = new RAuthItemDataProvider('roles', array(
            'type' => 2,
        ));
        return CHtml::listData($all_roles->fetchData(), 'name', 'description');
    }

    public function getConditionDenialList()
    {
        return array(
            self::STATUS_DISABLED => Yii::t('menu', 'да'),
            self::STATUS_ACTIVE   => Yii::t('menu', 'нет'),
        );
    }
}

<?php

/**
 * This is the model class for table "{{menu}}".
 *
 * The followings are the available columns in table '{{menu}}':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property integer $status
 */
class Menu extends CActiveRecord
{
    const STATUS_ACTIVE   = 1;
    const STATUS_DISABLED = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Menu the static model class
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
        return '{{menu}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, code', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('name, description', 'length', 'max' => 200),
            array('code', 'length', 'max' => 20),
            array('name, description', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array(
                'code',
                'match',
                'pattern' => '/^[a-zA-Z0-9_\-]+$/',
                'message' => Yii::t('menu', 'Строка содержит запрещенные символы {attribute}')
            ),
            array('code', 'unique'),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('id, name, code, description, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'menuItems' => array(self::HAS_MANY, 'Item', 'menu_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('menu', 'ID'),
            'name'        => Yii::t('menu', 'Название'),
            'code'        => Yii::t('menu', 'Уникальный код'),
            'description' => Yii::t('menu', 'Описание'),
            'status'      => Yii::t('menu', 'Статус'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return array statuses
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_DISABLED => Yii::t('menu', 'не активно'),
            self::STATUS_ACTIVE   => Yii::t('menu', 'активно'),
        );
    }

    /**
     * @return string status text
     */
    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('menu', 'неизвестно');
    }

    /**
     * Get items for CMenu or bootstrap.widgets.TbMenu
     * @param string $code menu code
     * @return array items array for CMenu or bootstrap.widgets.TbMenu
     */
    public function getItems($code)
    {
        $cacheKey = 'menu_'.$code;
        if (!Yii::app()->cache->get($cacheKey)) {
            Yii::app()->cache->set($cacheKey, $this->getItemsFromDb($code));
        }
        return $this->getUserItems(Yii::app()->cache->get($cacheKey));
    }

    /**
     * Set visibility for current user and set active class if current page is menu item
     * @param array $items
     * @return array $items
     */
    private function getUserItems($items = array())
    {
        $requestUri = rtrim(Yii::app()->request->requestUri, '/');
        $count = count($items);
        for ($i=0; $i<$count; $i++) {
            $items[$i]['visible'] = !empty($items[$i]['access']) ? Yii::app()->user->checkAccess($items[$i]['access']) : 1;
            if ($items[$i]['visible'] && rtrim($items[$i]['url'], '/#') == $requestUri) {
                $items[$i]['itemOptions'] = array('class' => 'active');
                return $items;
            }
        }
        return $items;
    }

    /**
     * Select items from Database
     * @param string $code
     * @param int $parent_id
     * @return array
     */
    private function getItemsFromDb($code, $parent_id = 0)
    {
        $results = Yii::app()->getDb()->createCommand()
            ->select('item.id, item.title, item.href, item.access')
            ->from(Item::model()->tableName() . ' item')
            ->join($this->tableName() . ' menu', 'item.menu_id=menu.id')
            ->where(
                array('and', 'menu.code=:code', 'item.parent_id=:pid', 'item.status=1'),
                array(':code' => $code, ':pid' => (int)$parent_id)
            )
            ->order('item.sort_order ASC')->queryAll();
        $items = array();
        if (empty($results)) {
            return $items;
        }
        foreach ($results as $result) {
            $items[] = array(
                'label'       => $result['title'],
                'url'         => $result['href'],
                'items'       => $this->getItemsFromDb($code, $result['id']),
                'access'      => $result['access'],
            );
        }
        return $items;
    }
}

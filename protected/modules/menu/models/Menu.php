<?php

/**
 * This is the model class for table "{{menu}}".
 *
 * The followings are the available columns in table '{{menu}}':
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property string $code
 * @property string $title
 * @property string $href
 * @property integer $type
 * @property string $access
 * @property boolean $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 *
 * @method roots() Named scope. Gets root node(s).
 * @method children() Named scope. Gets children for node (direct descendants only).
 * @method ancestors(int $depth=null) Named scope. Gets ancestors for node.
 * @method parent() Named scope. Gets parent of node.
 * @method isLeaf() Determines if node is leaf.
 * @method isRoot() Determines if node is root.
 *
 * The followings are the available model behaviors:
 * @property StatusBehavior $statusMain
 * @property NestedSetBehavior $tree
 */
class Menu extends CActiveRecord
{
    const STATUS_ON  = 1;
    const STATUS_OFF = 0;
    public $parentId = 0;

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
            array('root, title, href', 'required', 'on' => 'insert, update'),
            array('code, title', 'required', 'on' => 'insertRoot, updateRoot'),
            array('root, lft, rgt, level, type, create_user_id, update_user_id', 'numerical', 'integerOnly' => true),
            array('status', 'boolean'),
            array('code', 'length', 'max' => 20),
            array('title', 'length', 'max' => 100),
            array('href, access', 'length', 'max' => 200),
            array('access', 'length', 'max' => 50),
            array(
                'id, root, lft, rgt, level, code, title, href, type, access, status, create_time, update_time, create_user_id, update_user_id',
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
            'statusMain' => array(
                'class' => 'application.components.behaviors.StatusBehavior',
                'list'  => array(
                    self::STATUS_ON  => Yii::t('menu', 'включено'),
                    self::STATUS_OFF => Yii::t('menu', 'отключено'),
                )
            ),
            'tree' => array(
                'class'        => 'application.components.behaviors.NestedSetBehavior',
                'hasManyRoots' => true
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'             => Yii::t('menu', 'ID'),
            'root'           => Yii::t('menu', 'Родитель'),
            'level'          => Yii::t('menu', 'Уровень вложенности'),
            'code'           => Yii::t('menu', 'Уникальный код меню'),
            'title'          => Yii::t('menu', 'Заголовок'),
            'href'           => Yii::t('menu', 'Ссылка'),
            'access'         => Yii::t('menu', 'Уровень доступа'),
            'status'         => Yii::t('menu', 'Статус'),
            'create_time'    => Yii::t('menu', 'Создано'),
            'update_time'    => Yii::t('menu', 'Изменено'),
            'create_user_id' => Yii::t('menu', 'Автор'),
            'update_user_id' => Yii::t('menu', 'Изменил'),
        );
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            // need to delete menu cache when move node...
            if ($this->parentId && $this->parent()->find()->id != $this->parentId) {
                /** @var $oldParent Menu|NestedSetBehavior //see updateAction where setted parentId after load model */
                if ($oldParent = $this->findByPk($this->parentId)) {
                    Yii::app()->getCache()->delete(
                        'menu_' . ($oldParent->isRoot() ? $oldParent->code : $oldParent->ancestors()->find()->code)
                    );
                }
            }
            Yii::app()->getCache()->delete('menu_' . $this->ancestors()->find()->code);
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('root', $this->root, true);
        $criteria->compare('lft', $this->lft, true);
        $criteria->compare('rgt', $this->rgt, true);
        $criteria->compare('level', $this->level, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('href', $this->href, true);
        //$criteria->compare('type', $this->type);
        $criteria->compare('t.access', $this->access, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('create_time', $this->create_time);
        $criteria->compare('update_time', $this->update_time);
        $criteria->compare('create_user_id', $this->create_user_id);
        $criteria->compare('update_user_id', $this->update_user_id);

        $sort               = new CSort;
        $sort->defaultOrder = 't.root, t.lft';

        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'pagination' => array('pageSize' => $this->count()),
            'sort'       => $sort
        ));
    }

    public function getAccessList()
    {
        return CHtml::listData(Yii::app()->authManager->getAuthItems(2), 'name', 'description');
    }

    public function getParentsData()
    {
        $rows = Yii::app()->db->createCommand("SELECT id, level, title FROM {{menu}} ORDER BY root, lft")->queryAll();
        $data = array();
        foreach ($rows as $item) {
            $data[$item['id']] = str_repeat('→', ($item['level'] - 1)) . ' ' . $item['title'];
        }
        return $data;
    }

    public static function getAdminItems()
    {
        if (Yii::app()->user->isGuest || (!Yii::app()->user->checkAccess('Admin') && !Yii::app()->user->checkAccess('Editor'))) {
            return array();
        }
        if ($items = Yii::app()->getCache()->get('menu_admin')) {
            if (isset(Yii::app()->controller->module) && isset(Yii::app()->controller->module->adminMenu)) {
                $items[0]['items'][get_class(Yii::app()->controller->module)]['items'] = Yii::app()->controller->module->adminMenu;
            }
            return $items;
        }
        $items = array();
        foreach (Yii::app()->getModules() as $config) {
            if ($config['class'] == 'system.gii.GiiModule') {
                continue;
            }
            Yii::import($config['class']);
            $className = array_pop(explode('.', $config['class']));
            if (is_callable($className . '::getAdminLink')) {
                $items[$className] = call_user_func($className . '::getAdminLink');
            }
        }
        $items = array(
            array(
                'label' => Yii::t('menu', 'Управление'),
                'url'   => '/admin',
                'items' => array_filter($items)
            )
        );
        $dependency = new CDirectoryCacheDependency(Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . 'modules');
        $dependency->recursiveLevel = 1;
        Yii::app()->getCache()->set('menu_admin', $items, 0, $dependency);
        return $items;
    }

    /**
     * Get items for CMenu or bootstrap.widgets.TbMenu
     * @param string $code menu code
     * @return array items array for CMenu or bootstrap.widgets.TbMenu
     */
    public static function getItems($code)
    {
        $cacheKey = 'menu_'.$code;
        if (!$menu = Yii::app()->getCache()->get($cacheKey)) {
            $menu = self::getItemsFromDb($code);
            Yii::app()->getCache()->set($cacheKey, $menu);
        }
        return self::getUserItems($menu);
    }

    /**
     * Set visibility for current user and set active class if current page is menu item
     * @param array $items
     * @return array $items
     */
    private static function getUserItems($items = array())
    {
        $requestUri = rtrim(Yii::app()->getRequest()->requestUri, '/');
        $count = count($items);
        for ($i=0; $i<$count; $i++) {
            $items[$i]['visible'] = !empty($items[$i]['access']) ? (Yii::app()->user->isGuest ? 0 : Yii::app()->user->checkAccess($items[$i]['access'])) : 1;
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
     * @param Menu $menu
     * @return array
     */
    public static function getItemsFromDb($code = null, $menu = null)
    {
        $return = array();
        /** @var $menu Menu|NestedSetBehavior */
        if (!is_null($code) && is_null($menu)) {
            $menu = Menu::model()->findByAttributes(array('code' => $code, 'status' => 1));
        }

        $items = $menu->children()->findAllByAttributes(array('status' => 1));
        foreach ($items as $item) {
            /** @var $item Menu|NestedSetBehavior */
            $return[] = array(
                'label'       => $item->title,
                'url'         => $item->href,
                'items'       => !$item->isLeaf() ? self::getItemsFromDb(null, $item) : array(),
                'access'      => $item->access,
            );
        }
        return $return;
    }
}

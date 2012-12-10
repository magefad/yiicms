<?php
/**
 * @author Fadeev Ruslan
 * Date: 26.10.12
 * Time: 15:16
 */
class AdjacencyListBehavior extends CActiveRecordBehavior
{
    /**
     * @var string the name of the attribute that stores value
     */
    public $valueAttribute;

    /**
     * @var string the name of the attribute that stores text
     */
    public $textAttribute = 'title';

    /**
     * @var string the name of the attribute that stores parent ID
     */
    public $parentAttribute = 'parent_id';

    /**
     * @var string the name of the attribute that stores level
     */
    public $levelAttribute = 'level';

    /**
     * @var string The name of the attribute that stores sort order.
     * Defaults to 'sort_order'
     */
    public $sortAttribute = 'sort_order';

    /**
     * @var int
     */
    private $_parentIdCurrentValue;


    public function afterFind($event)
    {
        $this->_parentIdCurrentValue = (int)$this->owner->{$this->parentAttribute};
        return parent::afterFind($event);
    }

    public function beforeSave($event)
    {
        if (!$this->owner->{$this->parentAttribute}) {
            $this->owner->setAttribute($this->parentAttribute, null);
            $this->owner->setAttribute($this->levelAttribute, 1);
        } else if ($this->_parentIdCurrentValue != $this->owner->attributes[$this->parentAttribute]) {
            if ($parent = $this->owner->findByPk($this->owner->{$this->parentAttribute})) {
                $this->owner->setAttribute($this->levelAttribute, $parent->{$this->levelAttribute} + 1);
                if ($lastChildSortOrder = Yii::app()->db->createCommand("SELECT MAX({$this->sortAttribute}) FROM {$this->owner->tableName()} WHERE parent_id={$parent->primaryKey}")->queryScalar()) {
                    $this->owner->setAttribute($this->sortAttribute, $lastChildSortOrder);
                } else {
                    $this->owner->setAttribute($this->sortAttribute, $parent->{$this->sortAttribute});
                }
            }
        }
        return parent::beforeSave($event);
    }

    public function getListData($valueField = '', $textField = '')
    {
        $this->valueAttribute = empty($valueField) ? $this->owner->tableSchema->primaryKey : $valueField;
        $this->textAttribute  = empty($valueField) ? $this->textAttribute : $textField;
        //$this->makeTreeData($this->makeTreeArray($this->getListArray()));
        return CHtml::listData($this->getListArray(), $this->valueAttribute, $this->textAttribute);
    }

    public function makeTreeArray(array &$listArray, $parentId = 0)
    {
        $branch = array();
        foreach ($listArray as $element) {
            if ($element[$this->parentAttribute] == $parentId) {
                $children = $this->makeTreeArray($listArray, $element[$this->owner->tableSchema->primaryKey]);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element[$this->owner->tableSchema->primaryKey]] = $element;
            }
        }
        return $branch;
    }

    public function getListArray($space = '→ ', $level = true)
    {
        $sql        = "SELECT {$this->owner->tableSchema->primaryKey}, {$this->valueAttribute}, {$this->textAttribute}, {$this->parentAttribute}, {$this->levelAttribute} FROM {$this->owner->tableName()} ORDER BY {$this->sortAttribute}";
        $dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM ' . $this->owner->tableName());
        $array      = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();

        $listArray = array();
        foreach ($array as $data) {
            if ($level) {
                $data[$this->textAttribute] = str_repeat($space, $data[$this->levelAttribute]) . $data[$this->textAttribute];
            }
            $listArray[$data[$this->owner->tableSchema->primaryKey]] = $data;
        }
        return $listArray;
    }
}

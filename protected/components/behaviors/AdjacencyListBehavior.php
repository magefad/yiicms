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
     * @var string The name of the attribute that stores sort order.
     * Defaults to 'sort_order'
     */
    public $sortAttribute = 'sort_order';

    /**
     * @var array list for CHtml::listData
     */
    private $_listData = array();

    public function getListData($valueField = '', $textField = '')
    {
        $this->valueAttribute = empty($valueField) ? $this->owner->tableSchema->primaryKey : $valueField;
        $this->textAttribute  = empty($valueField) ? $this->textAttribute : $textField;

        $this->_listData[] = array(
            $this->valueAttribute => 0,
            $this->textAttribute  => Yii::t('AdminModule.behavior', 'Корень')
        );
        $this->makeTreeData($this->makeTreeArray($this->getListArray()));
        return CHtml::listData($this->_listData, $this->valueAttribute, $this->textAttribute);
    }

    public function makeTreeData($treeArray, $pass = 0, $space = '→ ')
    {
        foreach ($treeArray as $element) {
            foreach ($element as $key => $value) {
                if (!is_array($value) && $key == $this->textAttribute) {
                    $element[$key] = str_repeat($space, $pass) . $value;
                }
            }
            $this->_listData[] = array_diff_key($element, array('children' => 0));
            if (array_key_exists('children', $element)) {
                $this->makeTreeData($element['children'], $pass + 1);
            }
        }
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

    public function getListArray()
    {
        $sql        = "SELECT {$this->owner->tableSchema->primaryKey}, {$this->valueAttribute}, {$this->textAttribute}, {$this->parentAttribute} FROM {$this->owner->tableName()} ORDER BY {$this->sortAttribute}";
        $dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM ' . $this->owner->tableName());
        $array      = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();

        $listArray = array();
        foreach ($array as $data) {
            $listArray[$data[$this->owner->tableSchema->primaryKey]] = $data;
        }
        return $listArray;
    }
}

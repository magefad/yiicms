<?php
/**
 * User: fad
 * Date: 23.07.12
 * Time: 13:16
 */
class Tree
{
    private $data = array();

    /**
     * @var string column name of attribute in <option>column_name->value</option>
     */
    public $name = 'name';

    public function makeDropDown($parents)
    {
        foreach ($parents as $parent) {
            $this->data[$parent->id] = $parent->{$this->name};
            #if ( isset($parent->children) )
            $this->subDropDown($parent->children);
        }
        return $this->data;
    }

    public function subDropDown($children, $space = '→ ')
    {
        foreach ($children as $child) {
            $this->data[$child->id] = $space . $child->{$this->name};
            $this->subDropDown($child->children, $space . $space);
        }
    }
}

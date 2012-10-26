<?php
/**
 * SortableBehaviour class file.
 *
 * @author: fad
 * Date: 25.10.12
 * Time: 16:27
 */

/**
 * SortableBehavior will automatically update sortAttributes values when we are change sort value of one model.
 *
 * You may specify an active record model to use this behavior like so:
 * <pre>
 * public function behaviors(){
 *     return array(
 *         'SortableBehavior' => array(
 *             'class' => 'application.modules.admin.behaviors.SortableBehavior',
 *             'sortAttribute' => 'sort_order_attribute',
 *             'optionsTitleAttribute' => 'title_attribute'
 *         )
 *     );
 * }
 * </pre>
 * The {@link sortAttribute} option actually default to 'sort_order' respectively, so it is not required that you configure them.
 */
class SortableBehavior extends CActiveRecordBehavior
{
    /**
     * @var string The name of the attribute that stores sort order.
     * Defaults to 'sort_order'
     */
    public $sortAttribute = 'sort_order';

    /**
     * @var string The name of the attribute that stores label for DropDownList
     */
    public $optionsTitleAttribute = 'title';

    /**
     * @var integer The current sort order value of model before saved
     */
    private $_sortCurrentValue;


    public function dropDownList($form = null, $htmlOptions = array(), $row = false)
    {
        $data = $this->getOptionsData();
        $maxSortOrder = max(array_keys($data)) + 1;
        $data[$maxSortOrder] = Yii::t('AdminModule.behavior', 'Разместить в конец');
        if ($this->owner->isNewRecord) {
            $htmlOptions['options'][$maxSortOrder] = array('selected' => true);
        } else {
            $data[$this->owner->{$this->sortAttribute}] = Yii::t('AdminModule.behavior', ' - Оставить как есть - ');
        }

        $htmlOptions['options']['0'] = array('disabled' => true);

        if ($form !== null && $row) {
            /** @var $form TBActiveForm */
            return $form->dropDownListRow($this->owner, $this->sortAttribute, $data, $htmlOptions);
        } else {
            return CHtml::activeDropDownList($this->owner, $this->sortAttribute, $data, $htmlOptions);
        }
    }

    public function dropDownListRow($form = null, $htmlOptions = array())
    {
        return $this->dropDownList($form, $htmlOptions, 'row');
    }

    /**
     * @return array (id, title)
     */
    private function getOptionsData()
    {
        $data = CHtml::listData(
            Yii::app()->db->createCommand(
                "SELECT {$this->sortAttribute}, {$this->optionsTitleAttribute} FROM {$this->owner->tableName()}"
            )->queryAll(),
            $this->sortAttribute,
            $this->optionsTitleAttribute
        );
        return array_merge(array(0 => Yii::t('AdminModule.behavior', ' - Разместить перед: - ')), $data);
    }

    /**
     * Responds to {@link CModel::onAfterFind} event.
     * Overrides this method if you want to handle the corresponding event of the {@link CBehavior::owner owner}.
     * @param CEvent $event event parameter
     * @return boolean
     */
    public function afterFind($event)
    {
        $this->_sortCurrentValue = (int)$this->owner->{$this->sortAttribute};
        return parent::afterFind($event);
    }

    /**
     * Responds to {@link CModel::onBeforeSave} event.
     * Overrides this method if you want to handle the corresponding event of the {@link CBehavior::owner owner}.
     * You may set {@link CModelEvent::isValid} to be false to quit the saving process.
     * @param CModelEvent $event event parameter
     * @return boolean
     */
    public function beforeSave($event)
    {
        if ($this->owner->isNewRecord && !$this->owner->attributes[$this->sortAttribute]) {
            if ($max = Yii::app()->db->createCommand("SELECT MAX({$this->sortAttribute}) FROM {$this->owner->tableName()}")->queryScalar()) {
                $this->owner->setAttribute($this->sortAttribute, $max + 1);
            }
        } else {
            if ($this->owner->attributes[$this->sortAttribute] > $this->_sortCurrentValue) {
                $this->owner->updateCounters(
                    array($this->sortAttribute => -1),
                    "{$this->sortAttribute} <= :sortNewValue AND {$this->sortAttribute}>=:_sortCurrentValue",
                    array('sortNewValue' => $this->owner->attributes[$this->sortAttribute], '_sortCurrentValue' => $this->_sortCurrentValue)
                );
            } else if ($this->owner->attributes[$this->sortAttribute] < $this->_sortCurrentValue) {
                $this->owner->updateCounters(
                    array($this->sortAttribute => +1),
                    "{$this->sortAttribute} <= :sortNewValue AND {$this->sortAttribute}>=:_sortCurrentValue",
                    array('sortNewValue' => $this->owner->attributes[$this->sortAttribute], '_sortCurrentValue' => $this->_sortCurrentValue)
                );
            }
        }
        return parent::beforeSave($event);
    }
}

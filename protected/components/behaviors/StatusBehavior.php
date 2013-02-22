<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 09.11.12
 * Time: 17:17
 */
class StatusBehavior extends CActiveRecordBehavior
{
    const STATUS_DRAFT      = 0;
    const STATUS_PUBLISHED  = 1;
    const STATUS_MODERATION = 2;

    /**
     * @var string the name of the table field where data is stored.
     * Required to set on init behavior. Default is status.
     */
    public $attribute = 'status';

    /**
     * @var array the possible list.
     * Default draft, published, archived
     * @see getList, setlist
     */
    protected $_list = array();

    protected $_status = null;
    protected $_text = ' - ';

    public function attach($owner)
    {
        if (empty($this->_list)) {
            $this->_list = array(
                self::STATUS_DRAFT      => Yii::t('AdminModule.Behavior', 'Черновик'),
                self::STATUS_PUBLISHED  => Yii::t('AdminModule.Behavior', 'Опубликовано'),
                self::STATUS_MODERATION => Yii::t('AdminModule.Behavior', 'На модерации'),
            );
        }
        parent::attach($owner);
    }

    /**
     * @return string the status.
     * @see getStatus
     */
    public function __toString()
    {
        return $this->getStatus();
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->_list;
    }

    /**
     * Init valid list values.
     * @param array $list valid values for status.
     * @return CActiveRecord owner model.
     */
    public function setList($list)
    {
        if (is_array($list) && !empty($list)) {
            $this->_list = $list;
        }
        return $this->owner;
    }

    /**
     * @return string status value.
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * @return string status text.
     */
    public function getText()
    {
        return $this->_text;
    }

    /**
     * Set status for model.
     * @param mixed $status value or status text for model.
     * @return CActiveRecord owner model.
     * @throws CException if status invalid.
     */
    public function setStatus($status)
    {
        if (isset($this->_list[$status])) {
            $this->_status = $status;
        } else if (($this->_status = array_search($status, $this->_list)) === false) {
            throw new CException(Yii::t('AdminModule.behavior', 'Status "{status}" is not allowed.', array('{status}' => $status)));
        }

        $this->_text = $this->_list[$this->_status];
        $this->owner->setAttribute($this->attribute, $this->_status);

        return $this->owner;
    }

    /**
     * Save status. Will be save only status attribute for model.
     * @return boolean whether the saving succeeds.
     */
    public function save()
    {
        return $this->owner->update(array($this->attribute));
    }

    /**
     * Load status after find model.
     * @param CEvent
     */
    public function afterFind($event)
    {
        $this->_status = $this->owner->getAttribute($this->attribute);
        $this->_text = isset($this->_list[$this->_status]) ? $this->_list[$this->_status] : ' - ';

        parent::afterFind($event);
    }
}

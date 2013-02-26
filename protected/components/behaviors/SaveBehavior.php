<?php
/**
 * SaveBehavior class file.
 *
 * @author: fad
 * Date: 24.10.12
 * Time: 14:04
 */

/**
 * SaveBehavior will automatically fill date and time related attributes.
 *
 * SaveBehavior will automatically fill date and time, createUser and updateUser
 * related attributes when the active record is created and/or updated.
 * You may specify an active record model to use this behavior like so:
 * <pre>
 * public function behaviors(){
 *     return array(
 *         'SaveBehavior' => array(
 *             'class' => 'application.components.behaviors.SaveBehavior',
 *             'createAttribute' => 'create_time_attribute',
 *             'updateAttribute' => 'update_time_attribute',
 *             'createUserAttribute' => 'create_user_id_attribute',
 *             'updateUserAttribute' => 'update_user_id_attribute',
 *         )
 *     );
 * }
 * </pre>
 * The {@link createAttribute}, {@link updateAttribute}, {@link createUserAttribute}, {@link updateUserAttribute}
 * options actually default to 'create_time', 'update_time', 'create_user_id', 'update_user_id',
 * respectively, so it is not required that you configure them. If you do not wish SaveBehavior
 * to set a timestamp  or userId for record update or creation, set the corresponding attribute option to null.
 *
 * By default, the update attribute is only set on record update. If you also wish it to be set on record creation,
 * set the {@link setUpdateOnCreate} option to true.
 *
 * Although SaveBehavior attempts to figure out on it's own what value to inject into the timestamp attribute,
 * you may specify a custom value to use instead via {@link timestampExpression}
 */
Yii::import('zii.behaviors.CTimestampBehavior');
class SaveBehavior extends CTimestampBehavior
{
    /**
     * @var array Maps column types to database method
     */
    protected static $map = array(
        'mssql'  => array(
            'datetime'  => 'GETDATE()',
            'timestamp' => 'GETDATE()',
            'date'      => 'GETDATE()',
        ),
        'mysql'  => array(
            'datetime'  => 'NOW()',
            'timestamp' => 'NOW()',
            'date'      => 'NOW()',
        ),
        'oci'    => array(
            'datetime'  => 'NOW()',
            'timestamp' => 'NOW()',
            'date'      => 'NOW()',
        ),
        'pgsql'  => array(
            'datetime'  => 'NOW()',
            'timestamp' => 'NOW()',
            'date'      => 'NOW()',
        ),
        'sqlite' => array(
            'datetime'  => 'datetime(\'now\')',
            'timestamp' => 'datetime(\'now\')',
            'date'      => 'date(\'now\')',
        )
    );

    /**
     * @var mixed The name of the attribute to store the create user.  Set to null to not
     * Defaults to 'create_user_id'
     */
    public $createUserAttribute = 'create_user_id';
    /**
     * @var mixed The name of the attribute to store the update user.  Set to null to not
     * Defaults to 'update_user_id'
     */
    public $updateUserAttribute = 'update_user_id';

    /**
     * Responds to {@link CModel::onBeforeSave} event.
     * Sets the values of the creation or modified attributes as configured
     *
     * @param CModelEvent $event event parameter
     */
    public function beforeSave($event)
    {
        $userId = Yii::app()->user->id;
        if ($this->owner->isNewRecord) {
            unset($this->owner->{$this->updateAttribute});//need to work default sql value (ex. CURRENT_TIMESTAMP)
            if ($this->createAttribute !== null) {
                $this->owner->{$this->createAttribute} = $this->getTimestampByAttribute($this->createAttribute);
            }
            if ($this->createUserAttribute !== null) {
                $this->owner->{$this->createUserAttribute} = $userId;
            }
        }
        if (!$this->owner->isNewRecord || $this->setUpdateOnCreate) {
            if (($this->updateAttribute !== null)) {
                $this->owner->{$this->updateAttribute} = $this->getTimestampByAttribute($this->updateAttribute);
            }
            if ($this->updateUserAttribute !== null) {
                $this->owner->{$this->updateUserAttribute} = $userId;
            }
        }
    }

    /**
     * Returns the appropriate timestamp depending on $columnType
     * rewritten for SQLite support
     * @param string $columnType $columnType
     * @return mixed timestamp (eg unix timestamp or a mysql function)
     */
    protected function getTimestampByColumnType($columnType)
    {
        $dbKey = Yii::app()->db->getDriverName();
        return isset(self::$map[$dbKey][$columnType]) ? new CDbExpression(self::$map[$dbKey][$columnType]) : time();
    }
}

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
 *             'class' => 'application.modules.admin.behaviors.SaveBehavior',
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
}

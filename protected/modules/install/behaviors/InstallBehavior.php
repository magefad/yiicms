<?php
/**
 * InstallBehavior.php class file.
 *
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

class InstallBehavior extends CModelBehavior
{
    /**
     * Load model attributes from user session
     */
    public function loadFromSession()
    {
        $this->owner->setAttributes(Yii::app()->user->getState(get_class($this->getOwner())));
    }

    /**
     * Save model attributes values in user session
     * Responds to {@link CModel::onAfterValidate} event.
     * @param CEvent $event event parameter
     */
    public function afterValidate($event)
    {
        Yii::app()->user->setState(get_class($this->owner), $this->owner->attributes);
    }
}

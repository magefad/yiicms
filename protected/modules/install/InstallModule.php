<?php
/**
 * InstallModule class file.
 *
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

class InstallModule extends CWebModule
{
    /**
     * @var mixed the layout that is shared by the controllers inside this module.
     */
    public $layout = 'install';

    /**
     * Returns the name of this module.
     * The default implementation simply returns {@link id}.
     * You may override this method to customize the name of this module.
     * @return string the name of this module.
     */
    public function getName()
    {
        return Yii::t('InstallModule.main', 'Installer');
    }

    /**
     * Returns the description of this module.
     * @return string the description of this module.
     */
    public function getDescription()
    {
        return Yii::t('InstallModule.main', 'Application installer module');
    }

    public function init()
    {
        $this->setImport(array('install.models.*', 'install.helpers.*'));
        Yii::app()->setComponents(
            array(
                'user' => array(
                    'class'          => 'CWebUser',
                    'stateKeyPrefix' => 'install',
                ),
                'executor' => array(
                    'class' => 'application.components.CommandExecutor',
                )
            ), false
        );
        Yii::app()->language = InstallHelper::getPreferredLanguage();
    }

    /**
     * The pre-filter for controller actions.
     * @param CController $controller the controller
     * @param CAction $action the action
     * @throws CHttpException if app installed
     * @return boolean whether the action should be executed.
     */
    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            if (is_file(Yii::getPathOfAlias('application.config') . DIRECTORY_SEPARATOR . 'db.php')) {
                throw new CHttpException(404, 'App already Installed!');
            } else {
                return true;
            }
        }
        return false;
    }
}

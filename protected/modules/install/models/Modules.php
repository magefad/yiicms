<?php
/**
 * Modules class file.
 *
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

class Modules extends CFormModel
{
    public $username;
    public $email;
    public $password;
    public $passwordConfirm;

    public $modules;

    public $saveSiteActions = true;

    public function rules()
    {
        return array(
            array('username, email, password, passwordConfirm', 'required'),
            array('email', 'email'),
            array('passwordConfirm', 'compare', 'compareAttribute' => 'password'),
            array('modules', 'safe')
        );
    }

    /**
     * Returns a list of behaviors that this model should behave as.
     * @return array the behavior configurations (behavior name=>behavior configuration)
     */
    public function behaviors()
    {
        return array(
            'behavior' => array(
                'class' => 'install.behaviors.InstallBehavior',
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'username'        => Yii::t('InstallModule.modules', 'Admin login'),
            'password'        => Yii::t('InstallModule.modules', 'Admin password'),
            'passwordConfirm' => Yii::t('InstallModule.modules', 'Confirm Password'),
            'modules'         => Yii::t('InstallModule.modules', 'Modules to install'),
        );
    }

    /**
     * @param string $id Module name
     * @param boolean $icon
     * @return string html module icon with name
     */
    public static function getModuleName($id, $icon = true)
    {
        $className = ucfirst($id) . 'Module';
        Yii::import('application.modules.' . $id . '.' . $className);
        // PHP 5.2 support :(
        return ($icon ? '<i class="icon-' . call_user_func($className . '::getIcon') . '"></i> ' : '') . call_user_func($className . '::getName');
    }

    public static function getModuleNameDescription($id)
    {
        $className = ucfirst($id) . 'Module';
        $name = self::getModuleName($id);
        $description = call_user_func($className . '::getDescription');
        return empty($description) ? $name : $name . ' — ' . $description;
    }

    /**
     * @return array key value modules
     */
    public static function getRequiredModules()
    {
        $names = array();
        foreach (array('user', 'admin', 'menu', 'page', 'news') as $id) {
            $names[$id] = self::getModuleName($id);
        }
        return $names;
    }

    /**
     * @return array key=>value available modules
     */
    public function getAvailableModules()
    {
        $modules_dirs = scandir(Yii::getPathOfAlias('application.modules'));
        $modules      = array();
        foreach ($modules_dirs as $id) {
            if ($id[0] == '.' || $id == Yii::app()->controller->module->id || (in_array($id, array_keys($this->getRequiredModules())))) {
                continue;
            }
            $className = ucfirst($id) . 'Module';
            Yii::import('application.modules.' . $id . '.' . $className);
            /** @var $className AdminModule|BlogModule|CommentModule|ContactModule|GalleryModule|MenuModule|NewsModule|PageModule|SitemapModule|SocialModule|UserModule */
            if (method_exists($className, 'getIcon')) {//@todo change check
                $modules[$id] = self::getModuleNameDescription($id);
            }
        }
        return $modules;
    }
}

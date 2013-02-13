<?php
/**
 * DefaultController.php class file.
 *
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

class DefaultController extends CController
{
    /**
     * @return array a list of filter configurations.
     */
    public function filters()
    {
        return array(
            'ajaxOnly + moduleInstall'/** @see CController::filterAjaxOnly */
        );
    }

    /**
     * Check Yii framework Requirements
     */
    public function actionIndex()
    {
        $this->render('index', InstallHelper::checkRequirements());
    }

    /**
     * Check CHMOD's fot paths
     */
    public function actionChmod()
    {
        $this->render('chmod', array('result' => InstallHelper::checkIsWritableDirectories()));
    }

    /**
     * Check connection settings and create Database
     */
    public function actionDatabase()
    {
        $model = new Database();
        $this->performAjaxValidation($model);

        if (isset($_POST['Database'])) {
            $model->attributes = $_POST['Database'];
            if ($model->validate()) {
                $dbCreateStatus = $model->createDb();
                if ($dbCreateStatus === true) {
                    Yii::app()->user->setState('configs', array('db' => $model->getDbConfig()));
                    $this->redirect(array('modules'));
                } else if (is_string($dbCreateStatus)) {
                    Yii::app()->user->setFlash('error', nl2br($dbCreateStatus));
                }
            }
        }
        $this->render('database', array('model' => $model));
    }

    /**
     * A\Select modules to be installed
     */
    public function actionModules()
    {
        $model = new Modules();
        $this->performAjaxValidation($model);

        if (isset($_POST['Modules'])) {
            $model->attributes = $_POST['Modules'];
            if ($model->validate()) {
                Yii::app()->user->setState(
                    'modulesInstall',
                    array_merge(array_keys($model->getRequiredModules()), $model->modules)
                );
                $this->redirect(array('modulesInstall'));
            }
        }
        $this->render('modules', array('model' => $model, 'requiredModules' => $model->getRequiredModules()));
    }

    /**
     * Install selected modules page
     */
    public function actionModulesInstall()
    {
        if (!$modules = Yii::app()->user->getState('modulesInstall')) {
            $this->invalidActionParams($this->action);
        }
        Yii::app()->user->setState(
            'configs',
            array_merge(
                Yii::app()->user->getState('configs'),
                array('modules' => array_merge($modules, array('auth' => array('userNameColumn' => 'username'))))
            )
        );
        $opts = CJavaScript::encode(
            array(
                'url'      => Yii::app()->createUrl('/install/default/moduleInstall'),
                'modules'  => $modules,
                'messages' => array(
                    'Installation' => Yii::t('InstallModule.modules', 'Installation'),
                )
            )
        );
        $assets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('install.assets'));
        Yii::app()->clientScript->registerScriptFile($assets . '/jquery.modulesInstall.js');
        Yii::app()->clientScript->registerScript('modulesInstall', "modulesInstall({$opts});");
        $this->render('modulesInstall', array('modules' => $modules));
    }

    /**
     * Ajax install module call from action ModulesInstall
     * @param string $id Module Id to install
     */
    public function actionModuleInstall($id)
    {
        Yii::app()->setModules(array($id));
        $error = false;
        $response = '';
        //migrate
        try {
            if (is_dir(Yii::getPathOfAlias('application.modules.' . $id . '.migrations'))) {
                $database = new Database();
                $database->behavior->loadFromSession();
                Yii::app()->setComponent('db', $database->createDbConnection(), false);
                $response = Yii::app()->executor->migrate('up --module=' . $id);
                if (stripos($response, 'successfully') === false) {
                    if (stripos($response, 'up-to-date') !== false) {
                        $response = Yii::t('InstallModule.modules', 'Module already installed');
                    } else {
                        $error = true;
                    }
                } else {
                    $response = strstr($response, '***');
                    if ($id == 'user' && !empty($response)) {
                        Yii::import('user.UserModule');
                        //create admin user
                        $model = new Modules();
                        $model->behavior->loadFromSession();
                        $user = new User;
                        $salt = $user->generateSalt();
                        $user->setAttributes(
                            array(
                                'firstname'         => $model->username,
                                'username'          => $model->username,
                                'country'           => 'Russia',
                                'email'             => $model->email,
                                'password'          => $user->hashPassword($model->password, $salt),
                                'salt'              => $salt,
                                'status'            => 'active',
                                'access_level'      => 1,
                                'registration_date' => new CDbExpression('NOW()'),
                                'registration_ip'   => Yii::app()->getRequest()->userHostAddress,
                                'email_confirm'     => 1,
                            )
                        );
                        $user->save(false);
                        $response .= PHP_EOL . Yii::t('InstallModule.modules', 'Created {username} user', array('{username}' => $model->username));

                        Yii::app()->setModules(array('auth'));
                        Yii::app()->authManager->clearAll();
                        Yii::app()->authManager->createRole('Admin', Yii::t('UserModule.user', 'Administrator'));
                        Yii::app()->authManager->createRole('Authenticated', Yii::t('UserModule.user', 'Registered user'), '!Yii::app()->user->getIsGuest()');
                        Yii::app()->authManager->createRole('Editor', Yii::t('UserModule.user', 'Redactor'));
                        foreach (array('Admin', 'Authenticated', 'Editor') as $role) {
                            $response .= PHP_EOL . Yii::t('InstallModule.modules', 'Created {role} role', array('{role}' => $role));
                        }
                        Yii::app()->authManager->assign('Admin', $user->id);
                        Yii::app()->authManager->assign('Editor', $user->id);
                        $modules = array_diff(scandir(Yii::getPathOfAlias('application.modules')), array('auth', 'install', 'sitemap', '.', '..'));
                        sort($modules);
                        foreach ($modules as $id) {
                            $controllersPath = Yii::getPathOfAlias('application.modules.' . $id . '.controllers');
                            if (is_dir($controllersPath)) {
                                $controllersNames = scandir($controllersPath);
                                foreach ($controllersNames as $name) {
                                    if (substr($name, -14) == 'Controller.php') {
                                        $name     = substr($name, 0, -14);
                                        $name[0]  = strtolower($name[0]);
                                        $taskName = $id . '.' . $name . '.*';
                                        Yii::app()->authManager->createTask($taskName, ucfirst($id) . ($name != 'default' ? ' ' . ucfirst($name) : ''));
                                        Yii::app()->authManager->addItemChild('Admin', $taskName);
                                    }
                                }
                            }
                        }
                        Yii::app()->authManager->save();
                    }
                }
            }
        } catch (Exception $e) {
            $response = $e->getMessage() . (YII_DEBUG ? $e->getTraceAsString() : '');
            $error = true;
        }
        echo CJSON::encode(array('response' => empty($response) ? Yii::t('InstallModule.modules', 'Module successfully installed') : nl2br($response), 'error' => $error));

        //run install method
        //Yii::app()->getModule($id)->install();
        Yii::app()->end();
    }

    /**
     * Create configs files (modules.php and db.php)
     */
    public function actionConfig()
    {
        $configs = Yii::app()->user->getState('configs');
        /** @see CModule::setModules() ;) */
        foreach ($configs['modules'] as $id => $module) {
            if (is_int($id)) {
                $configs['modules'][$module] = array();
                unset($configs['modules'][$id]);
            }
        }
        $fileWriteErrors = array();
        foreach ($configs as $fileName => $data) {
            if (InstallHelper::parseConfig($fileName, $data) === false) {
                $fileWriteErrors[$fileName] = InstallHelper::varExport($data);
            }
        }
        if (empty($fileWriteErrors)) {
            Yii::app()->user->setStateKeyPrefix('');
            Yii::app()->user->setFlash('success', 'Yes It Is!');
            $this->redirect(Yii::app()->getHomeUrl());
        } else {
            $this->render('config', array('fileWriteErrors' => $fileWriteErrors));
        }
    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->getRequest()->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    /**
     * Performs the AJAX validation.
     * @param Database|Modules $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}


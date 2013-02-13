<?php

class DefaultController extends Controller
{
    /**
     * @return array a list of filter configurations.
     */
    public function filters()
    {
        return array(
            'postOnly + delete',/** @see CController::filterPostOnly */
             array('auth.filters.AuthFilter')/** @see AuthFilter */
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new User;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $model->setAttributes(
                array(
                    'salt'              => $model->generateSalt(),
                    'password'          => $model->hashPassword($model->password, $model->salt),
                    'registration_ip'   => Yii::app()->getRequest()->userHostAddress,
                    'activation_ip'     => Yii::app()->getRequest()->userHostAddress,
                    'registration_date' => new CDbExpression("NOW()"),
                )
            );
            if ($model->save()) {
                /**
                 * If user is Admin access (not user), assign (Yii-auth) Admin Role for created user
                 */
                if (isset($model->attributes['access_level']) && $model->attributes['access_level']) {
                    Yii::app()->authManager->assign('Admin', $model->id);
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            $model->setAttributes($_POST['User']);

            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('user', 'Данные обновлены!'));
                $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('update', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * We only allow deletion via POST request @see CController::filterPostOnly
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param int $id the ID of the model to be deleted
     * @throws CHttpException 400 if not not POST request
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('User');
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
        }
        $this->render('admin', array('model' => $model));
    }

    /**
     * @param int $id User ID
     */
    public function actionChangepassword($id)
    {
        /** @var $model User */
        $model = $this->loadModel($id);
        $form  = new ChangePasswordForm;

        if (Yii::app()->getRequest()->isPostRequest && !empty($_POST['ChangePasswordForm'])) {
            $form->setAttributes($_POST['ChangePasswordForm']);
            if ($form->validate() && $model->changePassword($form->password)) {
                $model->changePassword($form->password);
                Yii::app()->user->setFlash('success', Yii::t('user', 'Пароль успешно изменен!'));
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('changepassword', array('model' => $model, 'changePasswordForm' => $form));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param int $id the ID of the model to be loaded
     * @throws CHttpException 404 if not found
     * @return User
     */
    public function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

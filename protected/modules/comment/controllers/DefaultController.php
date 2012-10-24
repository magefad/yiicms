<?php

class DefaultController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class'         => 'CCaptchaAction',
                'backColor'     => 0xFFFFFF,
            ),
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array('rights');
    }

    public function allowedActions()
    {
        return 'captcha, create, update, delete';
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
     * Creates a new comment.
     *
     * On Ajax request:
     *   on successFull creation comment/_view is rendered
     *   on error comment/_form is rendered
     * On POST request:
     *   If creation is successful, the browser will be redirected to the
     *   url specified by POST value 'returnUrl'.
     */
    public function actionCreate()
    {
        /** @var $model Comment */
        $model =  Yii::createComponent('Comment');
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Comment'])) {
            $model->attributes = $_POST['Comment'];
            // determine current users id
            $model->create_user_id = Yii::app()->user->isGuest ? null : Yii::app()->user->id;

            if (Yii::app()->request->isAjaxRequest) {
                $output = '';
                if ($model->save()) {
                    // refresh model to replace CDbExpression for timestamp attribute
                    $model->refresh();
                    // render new comment
                    $output .= $this->renderPartial('_view', array('data' => $model), true);
                    // create new comment model for empty form
                    $model = Yii::createComponent('Comment');
                    $model->model    = $_POST['Comment']['model'];
                    $model->model_id = $_POST['Comment']['model_id'];
                }
                // render comment form
                $output .= $this->renderPartial('_formAjax', array('model' => $model, 'ajaxId' => time()), true);
                // render javascript functions
                Yii::app()->clientScript->renderBodyEnd($output);
                echo $output;
                Yii::app()->end();
            } else {
                if ($model->save()) {
                    $this->redirect(
                        isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view', 'id' => $model->id)
                    );
                } else {
                    // @todo: what if save fails?
                }
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if ((!Yii::app()->user->isGuest && Yii::app()->user->id == $model->create_user_id) || Yii::app()->user->isSuperuser) {
            if (isset($_POST['Comment'])) {
                $model->attributes = $_POST['Comment'];
                if ($model->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        // refresh model to replace CDbExpression for timestamp attribute
                        $model->refresh();
                        // render updated comment
                        $this->renderPartial('_view', array('data' => $model));
                        Yii::app()->end();
                    } else {
                        $this->redirect(
                            isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view', 'id' => $model->id)
                        );
                    }
                }
            }

            if (Yii::app()->request->isAjaxRequest) {
                $output = $this->renderPartial('_formAjax', array('model'=> $model, 'ajaxId' => time()), true);
                // render javascript functions
                Yii::app()->clientScript->renderBodyEnd($output);
                echo $output;
                Yii::app()->end();
            } else {
                $this->render('update', array('model' => $model));
            }
        } else {
            throw new CHttpException(401, Yii::t('global', 'You don"t have permission to access this function'));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     * @throws CHttpException
     * @return void
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $model = $this->loadModel($id);
            if ((!Yii::app()->user->isGuest && Yii::app()->user->id == $model->create_user_id) || Yii::app()->user->isSuperuser) {
                $this->loadModel($id)->delete();
            } else {
                throw new CHttpException(401, Yii::t('global', 'You don"t have permission to access this function'));
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!Yii::app()->request->isAjaxRequest) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Comment');
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Comment('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Comment'])) {
            $model->attributes = $_GET['Comment'];
        }

        $this->render('admin', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param $id
     * @throws CHttpException
     * @internal param \the $integer ID of the model to be loaded
     * @return Comment
     */
    public function loadModel($id)
    {
        $model = Comment::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

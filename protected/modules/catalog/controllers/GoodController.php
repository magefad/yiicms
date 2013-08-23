<?php

class GoodController extends Controller
{
    public $defaultAction = 'admin';
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

    public function actionShow($slug = '')
    {
        if (empty($slug)) {
            $this->invalidActionParams($this->action);
        }
        /** @var $model Good */
        $model = Good::model()->published()->find('slug = :slug', array(':slug' => $slug));

        if (!$model) {
            $this->invalidActionParams($this->action);
        }
        $_GET['id'] = $model->id;
        $this->setMetaTags($model);
        $this->render('show', array('good' => $model));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $good = new Good;
        /** @var GoodData[] $goodData */
        $goodData = array();

        /** @var GoodTemplate[] $goodTemplate */
        $goodTemplate = GoodTemplate::model()->findAll();
        foreach ($goodTemplate as $_goodTemplate) {
            $goodData[$_goodTemplate->key] = new GoodData;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Good'])) {
            $valid = true;
            $transaction = $good->getDbConnection()->beginTransaction();
            $good->attributes = $_POST['Good'];
            if ($good->save()) {
                if (isset($_POST['GoodData'])) {
                    foreach ($_POST['GoodData'] as $key => $_goodData) {
                        if (empty($_goodData['value'])) {
                            continue;
                        }
                        $goodData[$key]->good_id = $good->getPrimaryKey();
                        $goodData[$key]->setAttribute('key', $key);
                        $goodData[$key]->setAttributes($_goodData);
                        if (!$goodData[$key]->save()) {
                            $valid = false;
                        }
                    }
                }
                if ($valid) {
                    $transaction->commit();
                    //$this->redirect(array('view', 'id' => $good->id));
                    $this->redirect(array('admin'));
                } else {
                    $transaction->rollback();
                }
            }
        }
        $this->render('create', array('good' => $good, 'goodData' => $goodData));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $good = $this->loadModel($id);
        /** @var GoodData[] $goodData */
        $goodData = array();
        /** @var GoodData[] $tempGoodData */
        $tempGoodData = GoodData::model()->findAllByAttributes(array('good_id' => $id));

        foreach ($tempGoodData as $_goodData) {
            $goodData[$_goodData->key] = $_goodData;
        }
        unset($tempGoodData);
        /** @var GoodTemplate[] $goodTemplate */
        $goodTemplate = GoodTemplate::model()->findAll();
        foreach ($goodTemplate as $_goodTemplate) {
            if (!array_key_exists($_goodTemplate->key, $goodData)) {
                $goodData[$_goodTemplate->key] = new GoodData;
            }
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Good'])) {
            $valid = true;
            $transaction = $good->getDbConnection()->beginTransaction();
            $good->attributes = $_POST['Good'];
            if ($good->save()) {
                if (isset($_POST['GoodData'])) {
                    foreach ($_POST['GoodData'] as $key => $_goodData) {
                        if (empty($_goodData['value'])) {
                            continue;
                        }
                        $goodData[$key]->good_id = $good->getPrimaryKey();
                        $goodData[$key]->setAttribute('key', $key);
                        $goodData[$key]->setAttributes($_goodData);
                        if (!$goodData[$key]->save()) {
                            $valid = false;
                        }
                    }
                }
                if ($valid) {
                    $transaction->commit();
                    //$this->redirect(array('view', 'id' => $good->id));
                    $this->redirect(array('admin'));
                } else {
                    $transaction->rollback();
                }
            }
        }

        $this->render('update', array('good' => $good, 'goodData' => $goodData));
    }

    /**
     * Deletes a particular model.
     * We only allow deletion via POST request @see CController::filterPostOnly
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param int $id the ID of the model to be deleted
     * @throws CHttpException
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
        $dataProvider = new CActiveDataProvider('Good');
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Good('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Good'])) {
            $model->attributes = $_GET['Good'];
        }

        $this->render('admin', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     * @param int $id
     * @throws CHttpException
     * @return Good     */
    public function loadModel($id)
    {
        $model = Good::model()->findByPk($id);
        if ($model===null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax']==='good-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

<?php

class CatalogItemController extends Controller
{
    public $defaultAction = 'admin';
    /**
     * @return array a list of filter configurations.
     */
    public function filters()
    {
        return array(
             'postOnly + delete',/** @see CController::filterPostOnly */
             array('auth.filters.AuthFilter - show')/** @see AuthFilter */
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
        /** @var $model CatalogItem */
        $model = CatalogItem::model()->published()->find('slug = :slug', array(':slug' => $slug));

        if (!$model) {
            $this->invalidActionParams($this->action);
        }
        $_GET['id'] = $model->id;
        $this->setMetaTags($model);
        $this->render('show', array('catalogItem' => $model));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $catalogItem = new CatalogItem;
        /** @var CatalogItemData[] $catalogItemData */
        $catalogItemData = array();

        /** @var CatalogItemTemplate[] $catalogItemTemplate */
        $catalogItemTemplate = CatalogItemTemplate::model()->findAll();
        foreach ($catalogItemTemplate as $_catalogItemTemplate) {
            $catalogItemData[$_catalogItemTemplate->key] = new CatalogItemData;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CatalogItem'])) {
            $valid = true;
            $transaction = $catalogItem->getDbConnection()->beginTransaction();
            $catalogItem->attributes = $_POST['CatalogItem'];
            if ($catalogItem->save()) {
                if (isset($_POST['CatalogItemData'])) {
                    foreach ($_POST['CatalogItemData'] as $key => $_catalogItemData) {
                        if (empty($_catalogItemData['value'])) {
                            continue;
                        }
                        $catalogItemData[$key]->item_id = $catalogItem->getPrimaryKey();
                        $catalogItemData[$key]->setAttribute('key', $key);
                        $catalogItemData[$key]->setAttributes($_catalogItemData);
                        if (!$catalogItemData[$key]->save()) {
                            $valid = false;
                        }
                    }
                }
                if ($valid) {
                    $transaction->commit();
                    //$this->redirect(array('view', 'id' => $catalogItem->id));
                    $this->redirect(array('admin'));
                } else {
                    $transaction->rollback();
                }
            }
        }
        $this->render('create', array('catalogItem' => $catalogItem, 'catalogItemData' => $catalogItemData));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $catalogItem = $this->loadModel($id);
        /** @var CatalogItemData[] $catalogItemData */
        $catalogItemData = array();
        /** @var CatalogItemData[] $tempCatalogItemData */
        $tempCatalogItemData = CatalogItemData::model()->findAllByAttributes(array('item_id' => $id));

        foreach ($tempCatalogItemData as $_catalogItemData) {
            $catalogItemData[$_catalogItemData->key] = $_catalogItemData;
        }
        unset($tempCatalogItemData);
        /** @var CatalogItemTemplate[] $catalogItemTemplate */
        $catalogItemTemplate = CatalogItemTemplate::model()->findAll();
        foreach ($catalogItemTemplate as $_catalogItemTemplate) {
            if (!array_key_exists($_catalogItemTemplate->key, $catalogItemData)) {
                $catalogItemData[$_catalogItemTemplate->key] = new CatalogItemData;
            }
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CatalogItem'])) {
            $valid = true;
            $transaction = $catalogItem->getDbConnection()->beginTransaction();
            $catalogItem->attributes = $_POST['CatalogItem'];
            if ($catalogItem->save()) {
                if (isset($_POST['CatalogItemData'])) {
                    foreach ($_POST['CatalogItemData'] as $key => $_catalogItemData) {
                        if (empty($_catalogItemData['value'])) {
                            continue;
                        }
                        $catalogItemData[$key]->item_id = $catalogItem->getPrimaryKey();
                        $catalogItemData[$key]->setAttribute('key', $key);
                        $catalogItemData[$key]->setAttributes($_catalogItemData);
                        if (!$catalogItemData[$key]->save()) {
                            $valid = false;
                        }
                    }
                }
                if ($valid) {
                    $transaction->commit();
                    //$this->redirect(array('view', 'id' => $catalogItem->id));
                    $this->redirect(array('admin'));
                } else {
                    $transaction->rollback();
                }
            }
        }

        $this->render('update', array('catalogItem' => $catalogItem, 'catalogItemData' => $catalogItemData));
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
        $dataProvider = new CActiveDataProvider('CatalogItem');
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new CatalogItem('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CatalogItem'])) {
            $model->attributes = $_GET['CatalogItem'];
        }

        $this->render('admin', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     * @param int $id
     * @throws CHttpException
     * @return CatalogItem     */
    public function loadModel($id)
    {
        $model = CatalogItem::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax']==='catalogItem-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

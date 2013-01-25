<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?>
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
        $model = new <?php echo $this->modelClass; ?>;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['<?php echo $this->modelClass; ?>'])) {
            $model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
            if ($model->save()) {
                $this->redirect(array('view', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
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

        if (isset($_POST['<?php echo $this->modelClass; ?>'])) {
            $model->attributes = $_POST['<?php echo $this->modelClass; ?>'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model-><?php echo $this->tableSchema->primaryKey; ?>));
            }
        }

        $this->render('update', array('model' => $model));
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
        $dataProvider = new CActiveDataProvider('<?php echo $this->modelClass; ?>');
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new <?php echo $this->modelClass; ?>('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['<?php echo $this->modelClass; ?>'])) {
            $model->attributes = $_GET['<?php echo $this->modelClass; ?>'];
        }

        $this->render('admin', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     * @param int $id
     * @throws CHttpException
     * @return <?php echo $this->modelClass; ?>
     */
    public function loadModel($id)
    {
        $model = <?php echo $this->modelClass; ?>::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax']==='<?php echo $this->class2id($this->modelClass); ?>-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

<?php

class DefaultController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array('rights');
    }

    /**
     * @return string the actions that are always allowed separated by commas.
     */
    public function allowedActions()
    {
        return 'index, show';
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
     * Show blog Posts
     * @param string $slug URL
     * @throws CHttpException
     */
    public function actionShow($slug)
    {
        $blog = Blog::model()->with('createUser', 'postsCount', 'membersCount', 'members')->find(
            'slug = :slug',
            array(':slug' => $slug)
        );

        if (!$blog) {
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Blog "{blog}" not found!', array('{blog}' => $slug)));
        }
        $this->setMetaTags($blog);

        $postsDataProvider = new CActiveDataProvider(Post::model()->published()->public(), array(
            'sort'     => array(
                'defaultOrder' => 'publish_time DESC',
            ),
            'criteria' => array(
                'condition' => 'blog_id = :blog_id',
                'params'    => array(':blog_id' => $blog->id),
            )
        ));
        $this->render(
            'show',
            array(
                'blog'                => $blog,
                'postsDataProvider'   => $postsDataProvider,
                'members'             => $blog->members,
            )
        );
    }

    public function actionIndex()
    {
        $postsDataProvider = new CActiveDataProvider(Post::model()->published()->public(), array(
            'sort' => array(
                'defaultOrder' => 'publish_time DESC',
            )
        ));
        $this->render('show', array('postsDataProvider' => $postsDataProvider));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Blog;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Blog'])) {
            $model->attributes = $_POST['Blog'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('BlogModule.blog', 'Blog added!'));
                $this->redirect(array('update', 'id' => $model->id));
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

        if (isset($_POST['Blog'])) {
            $model->attributes = $_POST['Blog'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('BlogModule.blog', 'Blog updated!'));
                $this->redirect(array('update', 'id' => $model->id));
            }
        }
        $this->render('update', array('model' => $model));
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
            $this->loadModel($id)->delete();
            Yii::app()->user->setFlash('info', Yii::t('BlogModule.blog', 'Blog deleted!'));
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionList()
    {
        $criteria     = Yii::app()->user->isGuest ? Blog::model()->published()->public() : Blog::model()->published();
        $dataProvider = new CActiveDataProvider($criteria);
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Blog('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Blog'])) {
            $model->attributes = $_GET['Blog'];
        }

        $this->render('admin', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param $id
     * @throws CHttpException
     * @internal param \the $integer ID of the model to be loaded
     * @return Blog
     */
    public function loadModel($id)
    {
        $model = Blog::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('global', 'The requested page does not exist.'));
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'blog-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

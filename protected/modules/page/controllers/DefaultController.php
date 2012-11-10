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

    public function allowedActions()
    {
        return 'show';
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
            $slug = Yii::app()->params['index'];
        } else if ( $slug == Yii::app()->params['index']) {
            $this->redirect('/', true, 301);
        }
        /** @var $page Page */
        $page = null;
        // preview
        if ((int)Yii::app()->request->getQuery('preview') === 1 && Yii::app()->user->isSuperUser) {
            $page = Page::model()->find('slug = :slug', array(':slug' => $slug));
        } else {
            $page = Page::model()->published()->find('slug = :slug', array(':slug' => $slug));
        }

        if (!$page) {
            throw new CHttpException('404', Yii::t('page', 'Страница не найдена или удалена!'));
        }
        if ($page->is_protected && Yii::app()->user->isGuest) {
            Yii::app()->user->setFlash('warning', Yii::t('page', 'Страница доступна только для авторизованных пользователей'));
            $this->redirect(Yii::app()->user->loginUrl);
        }
        $this->setMetaTags($page);
        if ((int)$page->parent_id) {
            $this->breadcrumbs = $this->getPageBreadCrumbs($page->parent);
            array_push($this->breadcrumbs, $page->title);
        }
        $this->render('show', array('page' => $page));
    }

    /**
     * Recursively get page parents to put in breadcrumbs
     * @param Page $page
     * @return array
     */
    public function getPageBreadCrumbs(Page $page)
    {
        $pages              = array();
        $pages[$page->name] = array('default/show', 'slug' => $page->slug);
        if ((int)$page->parent_id) {
            if ($parent = $page->parent) {
                $pages += $this->getPageBreadCrumbs($parent);
            }
        }
        return array_reverse($pages);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Page;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('page', 'Страница добавлена!'));
                if (isset($_POST['saveAndClose'])) {
                    $this->redirect(array('admin'));
                }
                $this->redirect(array('update', 'id' => $model->id));
            }
        }
        $criteria          = new CDbCriteria;
        $criteria->select  = new CDbExpression('MAX(sort_order) as sort_order');
        $max               = $model->find($criteria);
        $model->sort_order = $max->sort_order + 1;

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
        if (isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];
            if ($model->save()) {
                if (isset($_POST['saveAndClose'])) {
                    $this->redirect(array('admin'));
                }
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
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Page');
        $this->render('index', array('dataProvider' => $dataProvider,));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Page('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Page'])) {
            $model->attributes = $_GET['Page'];
        }
        $this->render('admin', array('model' => $model));
    }

    /**
     * Return javascript for TinyMce 'external_link_list_url' => '/page/default/MceListUrl'
     *
     */
    public function actionMceListUrl()
    {
        $items      = Page::model()->findAll(array('select' => 'name, slug'));
        $output     = 'var tinyMCELinkList = new Array(' . "\n\t";
        $itemsCount = count($items);
        foreach ($items as $item) {
            $itemsCount--;
            $endLine = ($itemsCount > 0 ? '/"],' : '/"]');
            $output .= '["' . CHtml::encode($item->name) . '", "' . $this->createUrl(
                '/page/default/show',
                array('slug' => $item->slug)
            ) . $endLine . "\n\t";
        }
        $output .= ');';

        header('Content-type: text/javascript');
        echo $output;
        Yii::app()->end();
    }

    public function actionAjaxPreview()
    {
        #$model = $this->loadModel($id);
        $purifier = new CHtmlPurifier();
        header('Content-type: text/plain');
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        $page['content'] = $purifier->purify($_REQUEST['content']);
        $this->render('show', array('page' => $page));
        Yii::app()->end();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param $id
     * @throws CHttpException
     * @internal param \the $integer ID of the model to be loaded
     * @return Page
     */
    public function loadModel($id)
    {
        $model = Page::model()->with('author', 'changeAuthor')->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param $model CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

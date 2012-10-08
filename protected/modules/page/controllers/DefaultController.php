<?php

class DefaultController extends Controller
{
    public $currentPage;

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
        }
        /** @var $this->currentPage Page */
        $this->currentPage = null;

        // превью
        if ((int)Yii::app()->request->getQuery('preview') === 1 && Yii::app()->user->isSuperUser) {
            $this->currentPage = Page::model()->find('slug = :slug', array(':slug' => $slug));
        } else {
            $this->currentPage = Page::model()->published()->find('slug = :slug', array(':slug' => $slug));
        }

        if (!$this->currentPage || ($this->currentPage->is_protected == Page::PROTECTED_YES)) {
            throw new CHttpException('404', Yii::t('page', 'Страница не найдена или удалена!'));
        }
        $this->setMetaTags($this->currentPage);
        if (is_object($this->currentPage->parent)) {
            $this->breadcrumbs = array(
                $this->currentPage->parent->name => array('default/show', 'slug' => $this->currentPage->parent->slug),
                $this->currentPage->name,
            );
        }
        $this->render('show', array('page' => $this->currentPage));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Page;
        $model->setAttribute('status', 1);
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
        $criteria->select  = new CDbExpression('MAX(menu_order) as menu_order');
        $max               = $model->find($criteria);
        $model->menu_order = $max->menu_order + 1;

        $this->render('create', array('model' => $model, 'pages' => Page::model()->allPagesList));
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
            /*
            * If change sort order num
             */
            $currentMenuOrder  = $model->attributes['menu_order'];
            $model->attributes = $_POST['Page'];
            if ($model->attributes['menu_order'] > $currentMenuOrder) {
                $model->updateCounters(
                    array('menu_order' => -1),
                    'menu_order<=:menu_order AND menu_order>=:current_menu_order',
                    array('menu_order' => $model->attributes['menu_order'], 'current_menu_order' => $currentMenuOrder)
                );
            }
            if ($model->attributes['menu_order'] < $currentMenuOrder) {
                $model->updateCounters(
                    array('menu_order' => +1),
                    'menu_order>=:menu_order AND menu_order<=:current_menu_order',
                    array('menu_order' => $model->attributes['menu_order'], 'current_menu_order' => $currentMenuOrder)
                );
            }

            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('page', 'Страница обновлена!'));
                if (isset($_POST['saveAndClose'])) {
                    $this->redirect(array('admin'));
                }
                $this->redirect(array('update', 'id' => $model->id));
            }
        }
        $this->render('update', array('model' => $model, 'pages' => Page::model()->getAllPagesList($model->id)));
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
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
        $this->render('admin', array('model' => $model, 'pages' => Page::model()->allPagesList));
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
        $page['body'] = $purifier->purify($_REQUEST['body']);
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

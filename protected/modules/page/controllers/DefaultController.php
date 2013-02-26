<?php
/**
 * @property PageModule $module
 */
class DefaultController extends Controller
{
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

    public function behaviors()
    {
        return array(
            'InlineWidgetsBehavior' => array(
                'class'      => 'application.components.behaviors.InlineWidgetsBehavior',
                'widgets'    => array('application.modules.news.widgets.LastNews'),
                'startBlock' => '{{widget:',
                'endBlock'   => '}}',
            ),
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
            $slug = $this->module->defaultPage;
        } else if ( $slug == $this->module->defaultPage) {
            $this->redirect(Yii::app()->getHomeUrl(), true, 301);
        }
        /** @var $model Page */
        // preview
        if ((int)Yii::app()->getRequest()->getQuery('preview') === 1 && Yii::app()->user->isAdmin) {
            $model = Page::model()->find('slug = :slug', array(':slug' => $slug));
        } else {
            $model = Page::model()->published()->find('slug = :slug', array(':slug' => $slug));
        }

        if (!$model) {
            throw new CHttpException(404, Yii::t('page', 'Страница не найдена или удалена!'));
        }
        $_GET['id'] = $model->id;
        if ($slug != $this->module->defaultPage) {
            $this->httpCacheFilter($model->update_time);
        }
        if ($model->is_protected && Yii::app()->user->isGuest) {
            throw new CHttpException(403, Yii::t('page', 'Страница доступна только для авторизованных пользователей'));
        }
        $this->setMetaTags($model);
        if ($model->level > 1) {
            $this->breadcrumbs = $this->getPageBreadCrumbs($model->parent);
            array_push($this->breadcrumbs, $model->title);
            $navigation = Yii::app()->db->createCommand(
                'SELECT name, title, slug, sort_order FROM {{page}} WHERE (sort_order=' . ($model->sort_order - 1) . ' OR sort_order=' . ($model->sort_order + 1) . ") AND level={$model->level}"
            )->queryAll();
            if ($navigationCount = count($navigation)) {
                if ($navigationCount === 1) {
                    if ($navigation['0']['sort_order'] > $model->sort_order) {
                        $navigation['next'] = $navigation['0'];
                    } else {
                        $navigation['prev'] = $navigation['0'];
                    }
                } else {
                    $navigation['prev'] = $navigation['0'];
                    $navigation['next'] = $navigation['1'];
                    unset($navigation['1']);
                }
                unset($navigation['0']);
            }
        }
        $this->render('show', array('page' => $model, 'navigation' => isset($navigation) ? $navigation : array()));
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
        $items      = Page::model()->findAll(array('select' => 'name, slug, level', 'order' => 'sort_order'));
        $output     = 'var tinyMCELinkList = new Array(' . "\n\t";
        $itemsCount = count($items);
        foreach ($items as $item) {
            $itemsCount--;
            $endLine = ($itemsCount > 0 ? '"],' : '"]');
            $output .= '["' . str_repeat('—', $item->level - 1) . CHtml::encode($item->name) . '", "' . $this->createUrl('/page/default/show', array('slug' => $item->slug)) . $endLine . "\n\t";
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
     * @param int $id
     * @throws CHttpException 404 if not found
     * @return Page
     */
    public function loadModel($id)
    {
        $model = Page::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

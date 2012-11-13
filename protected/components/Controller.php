<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/main';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public $title;

    /**
     * @var string the meta keywords of the current page.
     */
    public $keywords = '';

    /**
     * @var string the meta description of the current page.
     */
    public $description = '';

    /**
     * @var AdminModule for access to the global site settings
     */
    public $admin;

    /**
     * Set page title, seo meta tags (keywords and description)
     * @param $seo
     */
    public function setMetaTags($seo)
    {
        $this->pageTitle   = $seo->title;
        $this->keywords    = $seo->keywords;
        $this->description = $seo->description;
    }

    public function init()
    {
        $this->admin = Yii::app()->getModule('admin');
        parent::init();
    }

    /**
     * Register Meta tags to page
     */
    public function afterRender()
    {
        if (!empty($this->keywords)) {
            Yii::app()->clientScript->registerMetaTag($this->keywords, 'keywords');
        }
        if (!empty($this->description)) {
            Yii::app()->clientScript->registerMetaTag($this->description, 'description');
        }
    }

    /**
     * CGridView ajax activate/deactivate
     * Update object status. Ex. active or draft
     * @throws CHttpException
     */
    public function actionActivate($id)
    {
        $status      = Yii::app()->request->getQuery('status');
        $modelClass  = Yii::app()->request->getQuery('model');
        $statusAttribute = Yii::app()->request->getQuery('statusAttribute');

        if (!isset($modelClass, $id, $status, $statusAttribute)) {
            throw new CHttpException(404, Yii::t('yii', 'Your request is invalid.'));
        }
        /** @var $model CActiveRecord */
        $model = new $modelClass;
        $model = $model->resetScope()->findByPk((int)$id);
        if (!$model) {
            throw new CHttpException(404, Yii::t('yii', 'Your request is invalid.'));
        }

        $model->$statusAttribute = $status;
        $model->update(array($statusAttribute));

        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * CGridView ajax sort
     * @throws CHttpException
     */
    public function actionSort($id)
    {
        $direction  = Yii::app()->request->getQuery('direction');
        $modelClass = Yii::app()->request->getQuery('model');
        $sortAttribute  = Yii::app()->request->getQuery('sortAttribute');
        if (!isset($direction, $id, $modelClass, $sortAttribute)) {
            throw new CHttpException(404, Yii::t('yii', 'Your request is invalid.'));
        }

        $model = CActiveRecord::model($modelClass)->resetScope()->findByPk((int)$id);
        if (!isset($model)) {
            throw new CHttpException(404, Yii::t('yii', 'Your request is invalid.'));
        }

        if ($direction === 'up') {
            CActiveRecord::model($modelClass)->resetScope()->updateCounters(
                array($sortAttribute => +1),
                $sortAttribute . '=' . ($model->{$sortAttribute} - 1)
            );
            $model->saveCounters(array($sortAttribute => -1));
        } else if ($direction === 'down') {
            CActiveRecord::model($modelClass)->resetScope()->updateCounters(
                array($sortAttribute => -1),
                $sortAttribute . '=' . ($model->{$sortAttribute} + 1)
            );
            $model->saveCounters(array($sortAttribute => +1));
        }

        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function actionAutoCompleteSearch()
    {
        $table     = Yii::app()->request->getQuery('table') ? '{{'.Yii::app()->request->getQuery('table').'}}' : '{{tag}}';
        $nameField = Yii::app()->request->getQuery('nameField') ? Yii::app()->request->getQuery('nameField') : 'name';
        $term      = Yii::app()->request->getQuery('term');

        $variants = array();

        if (Yii::app()->request->isAjaxRequest && !empty($term)) {
            $tags = Yii::app()->db->createCommand()->select($nameField)->from($table)->where(
                array('like', $nameField, $term . '%')
            )->queryAll();
            if (count($tags)) {
                foreach ($tags as $tag) {
                    $variants[] = $tag['name'];
                }
                echo CJSON::encode($variants);
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
        }
    }
}

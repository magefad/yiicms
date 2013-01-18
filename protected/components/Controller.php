<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 *
 * @method string decodeWidgets(string $text) Content parser
 */
class Controller extends CController
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
     * @param CActiveRecord $seo
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
        if (!empty($this->admin->googleAnalyticsAccount)) {
            Yii::app()->clientScript->registerScript('googleAnalyticsAccount', "var _gaq = _gaq || [];_gaq.push(['_setAccount', '{$this->admin->googleAnalyticsAccount}']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();", CClientScript::POS_END);
        }
    }

    /**
     * CGridView ajax activate/deactivate
     * Update object status. Ex. active or draft
     * @throws CHttpException 400 if model not found
     */
    public function actionActivate($id)
    {
        $status      = Yii::app()->request->getQuery('status');
        $modelClass  = Yii::app()->request->getQuery('model');
        $statusAttribute = Yii::app()->request->getQuery('statusAttribute');

        if (!isset($modelClass, $id, $status, $statusAttribute)) {
            $this->invalidActionParams($this->action);
        }
        /** @var $model CActiveRecord */
        $model = new $modelClass;
        $model = $model->resetScope()->findByPk((int)$id);
        if (!$model) {
            $this->invalidActionParams($this->action);
        }

        $model->$statusAttribute = $status;
        $model->update(array($statusAttribute));

        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * CGridView ajax sort
     * @throws CHttpException 400 if model not found
     */
    public function actionSort($id)
    {
        $direction  = Yii::app()->request->getQuery('direction');
        $modelClass = Yii::app()->request->getQuery('model');
        $sortAttribute  = Yii::app()->request->getQuery('sortAttribute');
        if (!isset($direction, $id, $modelClass, $sortAttribute)) {
            $this->invalidActionParams($this->action);
        }

        $model = CActiveRecord::model($modelClass)->resetScope()->findByPk((int)$id);
        if (!isset($model)) {
            $this->invalidActionParams($this->action);
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
            $this->invalidActionParams($this->action);
        }
    }

    /**
     * Generate http headers 304 Not Modified and etag
     * @see CHttpCacheFilter
     * @param string|integer|bool $lastModified
     * @param mixed|bool $etagSeed
     */
    public function httpCacheFilter($lastModified = false, $etagSeed = false)
    {
        $filter = new CHttpCacheFilter();
        $filter->lastModified = $lastModified;
        if ($etagSeed) {
            $filter->etagSeed = $etagSeed;
        }
        $filter->preFilter(null);
    }
}

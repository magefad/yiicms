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

	private $_assetsBase;

	/**
	 * @param string $title
	 */
	public function setPageTitle($title)
	{
		$this->pageTitle = $title;
	}

	public function setMetaTags($data)
	{
		$this->setPageTitle($data->title);
		$this->keywords = $data->keywords;
		$this->description = $data->description;
	}

	public function init()
	{
		$this->setPageTitle($this->title);
	}

	public function actionActivate()
	{
		$status = (int)Yii::app()->request->getQuery('status');
		$id     = (int)Yii::app()->request->getQuery('id');
		$modelClass   = Yii::app()->request->getQuery('model');
		$statusField  = Yii::app()->request->getQuery('statusField');

		if(!isset($modelClass,$id,$status,$statusField))
			throw new CHttpException(404,Yii::t('fad','Страница не найдена!'));

		$model = new $modelClass;
		$model = $model->resetScope()->findByPk($id);
		if(!$model)
			throw new CHttpException(404,Yii::t('fad','Страница не найдена!'));

		$model->$statusField = $status;
		$model->update(array($statusField));

		if(!Yii::app()->request->isAjaxRequest)
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

	}

	public function actionSort()
	{
		$direction  = Yii::app()->request->getQuery('direction');
		$id     	= (int)Yii::app()->request->getQuery('id');
		$modelClass = Yii::app()->request->getQuery('model');
		$sortField  = Yii::app()->request->getQuery('sortField');

		if(!isset($direction,$id,$modelClass,$sortField))
			throw new CHttpException(404,Yii::t('fad','Страница не найдена!'));

		$model = new $modelClass;
		$model_depends = new $modelClass;
		$model = $model->resetScope()->findByPk($id);
		if(!$model)
			throw new CHttpException(404,Yii::t('fad','Страница не найдена!'));

		if ( $direction === 'up' )
		{
			$model_depends = $model_depends->findByAttributes(array($sortField => ($model->$sortField-1)));
			$model_depends->$sortField++;
			$model->$sortField--;#example menu_order column in sql
		}
		else
		{
			$model_depends = $model_depends->findByAttributes(array($sortField => ($model->$sortField+1)));
			$model_depends->$sortField--;
			$model->$sortField++;
		}

		$model->update(array($sortField));
		$model_depends->update(array($sortField));

		if ( !Yii::app()->request->isAjaxRequest )
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

}
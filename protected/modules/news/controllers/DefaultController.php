<?php

class DefaultController extends Controller
{
	/**
	 * @var string the default layout for the views.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array('rights');
	}

	/**
	 * All users can see news and see index of news (list news)
	 * @return string
	 */
	public function allowedActions()
	{
		return 'show,index';
	}

	public function actionShow($slug)
	{
		$model = Yii::app()->user->isGuest ? News::model()->published()->public()->find('slug = :slug', array(':slug' => $slug)) : News::model()->published()->find('slug = :slug', array(':slug' => $slug));
		if ( !$model )
		{
			throw new CHttpException(404, Yii::t('news', 'Новость не найдена!'));
		}
		else
		{
			$this->setMetaTags($model);
			$this->render('show', array('model' => $model));
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new News;
		$model->setAttribute('status', 1);
		// $this->performAjaxValidation($model);

		if ( isset($_POST['News']) )
		{
			$model->attributes = $_POST['News'];
			if ( $model->save() )
			{
				Yii::app()->user->setFlash('notice', Yii::t('news', 'Новость добавлена!'));
				$this->redirect(array('view', 'id' => $model->id));
			}
		}
		$model->date = date('d.m.Y');

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		/** @var $model News */
		$model = $this->loadModel($id);
		// $this->performAjaxValidation($model);

		if ( isset($_POST['News']) )
		{
			/** rename upload path if slug (link) changed */
			if ( $model->attributes['slug'] != $_POST['News']['slug'] )
			{
				$model->renamePath($_POST['News']['slug']);
			}
			#rename image directory if slug (link) changed
			$model->attributes = $_POST['News'];
			if ( $model->save() )
			{
				Yii::app()->user->setFlash('notice', Yii::t('news', 'Новость добавлена!'));
				$this->redirect(array('view','id' => $model->id));
			}				
		}

		$this->render('update', array(
			'model' => $model,
		));
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
		if ( Yii::app()->request->isPostRequest )
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if ( !isset($_GET['ajax']) )
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
		{
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria = Yii::app()->user->isGuest ? News::model()->published()->public()->date() : News::model()->published()->date();
		$dataProvider = new CActiveDataProvider($criteria);

		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new News('search');
		$model->unsetAttributes(); // clear any default values
		if ( isset($_GET['News']) )
			$model->attributes = $_GET['News'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param $id
	 * @throws CHttpException
	 * @internal param \the $integer ID of the model to be loaded
	 * @return \CActiveRecord
	 */
	public function loadModel($id)
	{
		$model = News::model()->findByPk($id);
		if ( $model === null )
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param $model CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if ( isset($_POST['ajax']) && $_POST['ajax']==='news-form' )
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=> array(
				'class' => 'CCaptchaAction', 'backColor' => 0xFFFFFF,
			), // page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'   => array(
				'class' => 'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if ( $error = Yii::app()->errorHandler->error )
		{
			if ( Yii::app()->request->isAjaxRequest )
			{
				echo $error['message'];
			}
			else
			{
				$this->render('error', $error);
			}
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model = new ContactForm;
		#$this->performAjaxValidation($model);
		if ( isset($_POST['ContactForm']) )
		{
			$model->attributes = $_POST['ContactForm'];

			if ( $model->validate() )
			{
				$headers = "From: {$model->email}\r\nReply-To: {$model->email}\r\nContent-type: text/plain;charset=utf-8";
				if ( !$model->subject )
					$model->subject = Yii::t('site', 'Письмо с сайта '.Yii::app()->name);
				$body = '';
				foreach ( $model->attributes as $attribute => $value )
				{
					if ( in_array($attribute, array('verifyCode')) )
						continue;
					if ( $value )
						$body .= $model->getAttributeLabel($attribute).": ".$value."\r\n\r\n";
				}

				mail(Yii::app()->params['adminEmail'], $model->subject, $body, $headers);
				Yii::app()->user->setFlash('success', Yii::t('site', 'Спасибо за сообщение! Мы Вам обязательно ответим!'));
				$this->refresh();
			}
		}
		$this->render('contact', array('model'=> $model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model = new LoginForm;

		// if it is ajax validation request
		if ( isset($_POST['ajax']) && $_POST['ajax'] === 'login-form' )
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if ( isset($_POST['LoginForm']) )
		{
			$model->attributes = $_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ( $model->validate() && $model->login() )
			{
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login', array('model'=> $model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if ( isset($_POST['ajax']) && $_POST['ajax']==='contact-form' )
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
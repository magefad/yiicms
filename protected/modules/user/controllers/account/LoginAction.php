<?php
/**
 * User: fad
 * Date: 06.09.12
 * Time: 17:59
 */
class LoginAction extends CAction
{
	/**
	 * Displays the login page
	 */
	public function run()
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
				$this->controller->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->controller->render('login', array('model' => $model));
	}
}

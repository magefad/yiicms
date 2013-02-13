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
        if (!Yii::app()->user->isGuest) {
            Yii::app()->user->setFlash('info', Yii::t('user', 'Вы уже вошли на сайт'));
            $this->controller->redirect('/user/profile');
        }
        $service = Yii::app()->getRequest()->getQuery('service');
        /** if login from EAuth (facebook, google, vk etc. */
        if (isset($service)) {
            /** @var $authIdentity EAuthServiceBase */
            $authIdentity              = Yii::app()->eauth->getIdentity($service);
            $authIdentity->redirectUrl = Yii::app()->user->returnUrl;
            $authIdentity->cancelUrl   = $this->controller->createAbsoluteUrl('/user/account/login');

            if ($authIdentity->authenticate()) {
                $identity = new CustomEAuthUserIdentity($authIdentity);
                // success
                if ($identity->authenticate()) {
                    $duration = 3600 * 24 * 30; // 30 days
                    Yii::app()->user->login($identity, $duration);
                    $authIdentity->redirect();
                } else {
                    // close popup window and redirect to cancelUrl
                    #$authIdentity->cancel();
                }
            }
            $authIdentity->redirect('/user/account/login');
        }

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

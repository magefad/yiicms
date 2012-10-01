<?php

/**
 * User: fad
 * Date: 06.09.12
 * Time: 18:39
 */
class DefaultController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class'     => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    /**
     * Displays the contact page
     */
    public function actionIndex()
    {
        $model = new ContactForm;
        #$this->performAjaxValidation($model);
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];

            if ($model->validate()) {
                $headers = "From: $model->name <{$model->email}>\r\n" . "Reply-To: {$model->email}\r\n" . "MIME-Version: 1.0\r\n" . "Content-type: text/plain; charset=UTF-8";

                if (!$model->subject) {
                    $model->subject = Yii::t('contact', 'Письмо с сайта ' . Yii::app()->name);
                }
                $body = '';
                foreach ($model->attributes as $attribute => $value) {
                    if (in_array($attribute, array('verifyCode'))) {
                        continue;
                    }
                    if ($value) {
                        $body .= $model->getAttributeLabel($attribute) . ": " . $value . "\r\n\r\n";
                    }
                }
                $body .= "\r\nReferer: " . Yii::app()->request->getUrlReferrer();
                $body .= "\r\nIP: " . Yii::app()->request->userHostAddress;

                if (mail($this->admin->email, $model->subject, $body, $headers)) {
                    Yii::log($body);
                    Yii::app()->user->setFlash(
                        'success',
                        Yii::t('contact', 'Спасибо за сообщение! Мы Вам обязательно ответим!')
                    );
                } else {
                    Yii::log($body, CLogger::LEVEL_ERROR);
                    Yii::app()->user->setFlash(
                        'success',
                        Yii::t('contact', 'Произошла проблема с отправкой письма! Обратитесь к администратоу: ' . $this->admin->email)
                    );
                }
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }
}

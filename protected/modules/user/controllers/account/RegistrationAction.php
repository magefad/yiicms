<?php
class RegistrationAction extends CAction
{
    public function run()
    {
        $form = new RegistrationForm('insert');
        $this->performAjaxValidation($form);
        if (!Yii::app()->user->isGuest) {
            $this->controller->redirect(Yii::app()->user->returnUrl);
        }

        if (Yii::app()->getRequest()->isPostRequest && isset($_POST['RegistrationForm'])) {
            $form->setAttributes($_POST['RegistrationForm']);
            #print_r($_POST);
            if ($form->validate()) {
                // если требуется активация по email
                if ($this->controller->module->emailAccountVerification) {
                    $user = new User;
                    // скопируем данные формы
                    $data = $form->getAttributes();
                    unset($data['verifyCode']);
                    $user->setAttributes($data);
                    $salt = $user->generateSalt();

                    $user->setAttributes(
                        array(
                            'salt'     => $salt,
                            'password' => $user->hashPassword($form->password, $salt),
                        )
                    );

                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($user->save()) {
                            // отправка email с просьбой активировать аккаунт
                            $message = new YiiMailMessage;
                            $message->view = 'registrationActivateEmail';
                            $message->setBody(array('user' => $user), 'text/html', Yii::app()->charset);
                            $message->subject = Yii::t('user', 'Регистрация на сайте {site} !', array('{site}' => Yii::app()->name));
                            $message->addTo($user->email);
                            $message->from = Yii::app()->getModule('admin')->email;
                            Yii::app()->mail->send($message);

                            $transaction->commit();

                            Yii::app()->user->setFlash('info', Yii::t('user', 'Учетная запись создана! Подтвердите email адрес следуя по ссылке в почтовом письме!'));
                            $this->controller->redirect(array('login'));
                        } else {
                            $form->addErrors($user->getErrors());

                            Yii::log(
                                Yii::t('user', "Ошибка при создании  учетной записи!"),
                                CLogger::LEVEL_ERROR,
                                UserModule::$logCategory
                            );
                        }
                    } catch ( Exception $e ) {
                        $transaction->rollback();
                        $form->addError('', $e->getMessage());
                    }
                } else {
                    // если активации не требуется - сразу создаем аккаунт
                }
            }
        }

        $this->controller->render('registration', array('model' => $form));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
            $model->scenario = 'ajax';
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
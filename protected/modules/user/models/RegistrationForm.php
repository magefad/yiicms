<?php
class RegistrationForm extends CFormModel
{
    public $username;
    public $email;
    public $password;
    public $verifyCode;

    public function rules()
    {
        #$module = Yii::app()->getModule('user');

        return array(
            array('username, email', 'filter', 'filter' => 'trim'),
            array('username, email', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('username, email, password', 'required'),
            array('password', 'length', 'min' => 4),
            array('username, email', 'length', 'max' => 50),
            array(
                'username',
                'match',
                'pattern' => '/^[A-Za-z0-9]{2,50}$/',
                'message' => Yii::t(
                    'user',
                    'Неверный формат поля "{attribute}" допустимы только латинские буквы и цифры, от 2 до 20 символов'
                )
            ),
            array('username', 'checkUserName'),
            array('email', 'email'),
            array('email', 'checkEmail'),
            array(
                'verifyCode',
                'captcha',
                'allowEmpty' => !CCaptcha::checkRequirements(),
                'on' => 'insert'
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'username'     => Yii::t('user', 'Имя пользователя'),
            'email'        => Yii::t('user', 'Email'),
            'password'     => Yii::t('user', 'Пароль'),
            'verifyCode'   => Yii::t('user', 'Введите код с картинки'),
        );
    }

    public function checkUserName()
    {
        $model = User::model()->find('username = :username', array(':username' => $this->username));
        if ($model) {
            $this->addError('username', Yii::t('user', 'Это имя уже занято!'));
        }
    }

    public function checkEmail()
    {
        $model = User::model()->find('email = :email', array(':email' => $this->email));
        if ($model) {
            $this->addError('email', Yii::t('user', 'Данный Email уже зарегистрирован'));
        }
    }
}
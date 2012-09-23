<?php
/**
 * User: fad
 * Date: 25.07.12
 * Time: 12:48
 */
class ChangePasswordForm extends CFormModel
{
    public $password;
    public $cPassword;

    public function rules()
    {
        return array(
            array('password, cPassword', 'required'),
            array(
                'password',
                'compare',
                'compareAttribute' => 'cPassword',
                'message'          => Yii::t('user', 'Пароли не совпадают!')
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'password'  => Yii::t('user', 'Новый пароль'),
            'cPassword' => Yii::t('user', 'Новый пароль еще раз'),
        );
    }
}

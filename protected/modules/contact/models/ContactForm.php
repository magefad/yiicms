<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
    public $name;
    public $email;
    public $subject;

    public $verifyCode;

    public $organization;
    /** @var int Количество торговых точек */
    public $countShop;
    /** @var string Образовательное учреждение */
    public $education;
    /** @var int Количество учащихся */
    public $countStudent;
    public $city;
    public $phone;

    public $body;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // name, email, subject and body are required
            array('name, email', 'required'),
            // email has to be a valid email address
            array('email', 'email'),
            array('countShop, countStudent', 'numerical', 'integerOnly' => true),
            array('organization, education, city, phone, body', 'safe'),
            // verifyCode needs to be entered correctly
            array(
                'verifyCode',
                'captcha',
                'allowEmpty' => !CCaptcha::checkRequirements() || !Yii::app()->getModule('contact')->captchaRequired
            ),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'name'             => Yii::t('contact', 'Как Вас зовут?'),
            'subject'          => Yii::t('contact', 'Тема письма'),
            'body'             => Yii::t('contact', 'Текст сообщения'),
            'verifyCode'       => Yii::t('contact', 'Введите код'),

            'organization'     => Yii::t('contact', 'Наименование организации'),
            'education'        => Yii::t('contact', 'Наименование учебного заведения'),
            'countShop'        => Yii::t('contact', 'Количество торговых точек'),
            'countStudent'     => Yii::t('contact', 'Количество учащихся'),
            'city'             => Yii::t('contact', 'Город'),
            'phone'            => Yii::t('contact', 'Контактный номер телефона'),
        );
    }
}

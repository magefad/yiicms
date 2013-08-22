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
            'name'             => Yii::t('ContactModule.contact', 'You name?'),
            'subject'          => Yii::t('ContactModule.contact', 'Message title'),
            'body'             => Yii::t('ContactModule.contact', 'Message Text'),
            'verifyCode'       => Yii::t('ContactModule.contact', 'Enter Code'),

            'organization'     => 'Наименование организации',
            'education'        => 'Наименование учебного заведения',
            'countShop'        => 'Количество торговых точек',
            'countStudent'     => 'Количество учащихся',
            'city'             => Yii::t('ContactModule.contact', 'City'),
            'phone'            => 'Контактный номер телефона',
        );
    }
}

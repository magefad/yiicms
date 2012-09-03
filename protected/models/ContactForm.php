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
			array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
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
			'name'             => Yii::t('site', 'Как Вас зовут?'),
			'subject'          => Yii::t('site', 'Тема письма'),
			'body'             => Yii::t('site', 'Текст сообщения'),
			'verifyCode'       => Yii::t('site', 'Введите код'),

			'organization'     => Yii::t('site', 'Наименование организации'),
			'education'        => Yii::t('site', 'Наименование учебного заведения'),
			'countShop'        => Yii::t('site', 'Количество торговых точек'),
			'countStudent'     => Yii::t('site', 'Количество учащихся'),
			'city'             => Yii::t('site', 'Город'),
			'phone'            => Yii::t('site', 'Контактный номер телефона'),
		);
	}
}
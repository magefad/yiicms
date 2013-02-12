<?php

class UserModule extends WebModule
{
    /**
     * @var int Minimum password length
     */
    public $minPasswordLength = 3;

    /**
     * @var bool enable activation by email
     */
    public $emailAccountVerification = true;

    /**
     * @var bool show captcha in registration fpr,
     */
    public $showCaptcha = true;
    public $minCaptchaLength = 3;
    public $maxCaptchaLength = 6;

    public static $logCategory = 'application.modules.user';

    public static function getAdminLink()
    {
        return array('icon' => self::getIcon(), 'label' => self::getName(), 'url' => array('/user/default/admin'));
    }

    public static function getName()
    {
        return Yii::t('user', 'Пользователи');
    }

    public static function getDescription()
    {
        return Yii::t('user', 'Управление пользователями сайта');
    }

    public static  function getIcon()
    {
        return 'user';
    }

    public function getSettingLabels()
    {
        return array(
            'minPasswordLength'        => Yii::t('admin', 'Минимальная длина пароль'),
            'emailAccountVerification' => Yii::t('admin', 'Включить активацию Email'),
            'showCaptcha'              => Yii::t('admin', 'Включить Captcha в форме регистрации'),
            'minCaptchaLength'         => Yii::t('admin', 'Минимальное число символов в Captcha'),
            'maxCaptchaLength'         => Yii::t('admin', 'Максимальное число символов в Captcha')
        );
    }

    public function getSettingData()
    {
        return array(
            'emailAccountVerification' => array(
                'data' => $this->getChoice(), //yes no
                'tag'  => 'radioButtonListInline',
            ),
            'showCaptcha'              => array(
                'data' => $this->getChoice(), //yes no
                'tag'  => 'radioButtonListInline',
            )
        );
    }

    public function init()
    {
        parent::init();
        /** @var $contact ContactModule */
        $contact = Yii::app()->getModule('contact');//get EMAIL settings
        $this->setImport(
            array(
                'user.models.*',
                'user.components.*',
                'user.extensions.eoauth.*',
                'user.extensions.eoauth.lib.*',
                'user.extensions.lightopenid.*',
                'user.extensions.eauth.*',
                'user.extensions.eauth.services.*',
                'user.extensions.eauth.custom_services.*',
                'ext.mail.YiiMailMessage',
            )
        );

        /**
         * Load Services Client_id and Client_secret and push it to array
         * If Open Id (yandex and google) push it anywhere.. (no need client_id and client_secret)
         * @var $socialModule SocialModule
         */
        $socialModule = Yii::app()->getModule('social');
        $servicesClasses = array('VKontakte', 'Facebook', 'Yandex', 'Google', 'Twitter', 'Mailru', 'Moikrug', 'Odnoklassniki');
        $services = array();

        foreach ($servicesClasses as $service) {
            $serviceClass        = 'Custom' . $service . 'Service';
            $serviceName         = strtolower($service);
            $serviceClientId     = $serviceName . 'ClientId';
            $serviceClientSecret = $serviceName . 'ClientSecret';
            unset($services[$service]);

            if (isset($socialModule->$serviceClientId) && !empty($socialModule->$serviceClientId)) {
                $services[$serviceName] = array(
                    'class'         => $serviceClass,
                    'client_id'     => $socialModule->$serviceClientId,
                    'client_secret' => $socialModule->$serviceClientSecret,
                );
            } else if (in_array($serviceName, array('yandex', 'google'))) {//Open ID is good... no need client_id and client_secret
                $services[$serviceName] = array(
                    'class'         => $serviceClass,
                );
            }
        }
        //load EAuth components
        Yii::app()->setComponents(
            array(
                'loid'  => array(
                    'class' => 'user.extensions.lightopenid.loid',
                ),
                'eauth' => array(
                    'class'       => 'user.extensions.eauth.EAuth',
                    'popup'       => true,
                    'cacheExpire' => 3600,
                    'services'    => $services
                ),
                'mail'  => array(
                    'class'         => 'ext.mail.YiiMail',
                    'transportType'    => $contact->smtpEnabled ? 'smtp' : 'php',
                    'transportOptions' => array(
                        'host'       => $contact->smtpHost,
                        'username'   => $contact->smtpUserName,
                        'password'   => $contact->smtpPassword,
                        'port'       => $contact->smtpPort,
                        'encryption' => $contact->smtpEncryption,
                    ),
                    'viewPath'      => 'user.views.mail',
                    'logging'       => true,
                    'dryRun'        => false
                )
            )
        );
    }

    /**
     * @param Controller $controller
     * @param CAction $action
     * @return bool
     */
    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            if ($controller->id == 'default') {
                $controller->menu = self::getAdminMenu();
            }
            return true;
        } else {
            return false;
        }
    }

    public function isAllowedEmail($email)
    {
        if (is_array($this->emailBlackList) && count($this->emailBlackList)) {
            if (in_array(trim($email), $this->emailBlackList)) {
                return false;
            }
        }
        return true;
    }
}

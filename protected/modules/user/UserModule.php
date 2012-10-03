<?php

class UserModule extends WebModule
{
    public $minPasswordLength = 3;
    public $emailAccountVerification = true;
    public $showCaptcha = true;
    public $minCaptchaLength = 3;
    public $maxCaptchaLength = 6;

    public static $logCategory = 'application.modules.user';

    public function getName()
    {
        return Yii::t('user', 'Пользователи');
    }

    public function getDescription()
    {
        return Yii::t('user', 'Управление пользователями сайта');
    }

    public function getIcon()
    {
        return 'user';
    }

    public function init()
    {
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
                    'transportType' => 'php',
                    'viewPath'      => 'user.views.mail',
                    'logging'       => true,
                    'dryRun'        => false
                )
            )
        );
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

<?php
/**
 * User: fad
 * Date: 03.10.12
 * Time: 16:19
 */
class SocialModule extends WebModule
{
    public $vkontakteClientId;
    public $vkontakteClientSecret;
    public $facebookClientId;
    public $facebookClientSecret;

    public static function getName()
    {
        return Yii::t('SocialModule.social', 'Социальные сети');
    }

    public static function getDescription()
    {
        return Yii::t('SocialModule.social', 'Настройки интеграции с сервисами социальных сетей');
    }

    public function getSettingLabels()
    {
        return array(
            'vkontakteClientId'     => Yii::t('SocialModule.social', 'Вконтакте client_id'),
            'vkontakteClientSecret' => Yii::t('SocialModule.social', 'Вконтакте client_secret'),
            'facebookClientId'      => Yii::t('SocialModule.social', 'Facebook client_id'),
            'facebookClientSecret'  => Yii::t('SocialModule.social', 'Facebook client_secret'),
        );
    }

    public function getSettingData()
    {
        return array(
            'vkontakteClientId' => array(
                'htmlOptions' => array(
                    'hint' => Yii::t('SocialModule.social', 'Регистрация приложения:' . CHtml::link(' http://vk.com/editapp?act=create&site=1', 'http://vk.com/editapp?act=create&site=1', array('target' => '_blank'))),
                )
            ),
            'facebookClientId' => array(
                'htmlOptions' => array(
                    'hint' => Yii::t('SocialModule.social', 'Регистрация приложения:'  . CHtml::link(' https://developers.facebook.com/apps/', ' https://developers.facebook.com/apps/', array('target' => '_blank'))),
                )
            ),
        );
    }

    public function init()
    {
        parent::init();
    }
}

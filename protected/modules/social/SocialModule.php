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
        return Yii::t('SocialModule.social', 'Social Networks');
    }

    public static function getDescription()
    {
        return Yii::t('SocialModule.social', 'Integrate social services with site');
    }

    public function getSettingLabels()
    {
        return array(
            'vkontakteClientId'     => 'Вконтакте client_id',
            'vkontakteClientSecret' => 'Вконтакте client_secret',
            'facebookClientId'      => 'Facebook client_id',
            'facebookClientSecret'  => 'Facebook client_secret',
        );
    }

    public function getSettingData()
    {
        return array(
            'vkontakteClientId' => array(
                'htmlOptions' => array(
                    'hint' => Yii::t('SocialModule.social', 'Register link:') . CHtml::link(' http://vk.com/editapp?act=create&site=1', 'http://vk.com/editapp?act=create&site=1', array('target' => '_blank')),
                )
            ),
            'facebookClientId' => array(
                'htmlOptions' => array(
                    'hint' => Yii::t('SocialModule.social', 'Register link:')  . CHtml::link(' https://developers.facebook.com/apps/', ' https://developers.facebook.com/apps/', array('target' => '_blank')),
                )
            ),
        );
    }

    public function init()
    {
        parent::init();
    }
}

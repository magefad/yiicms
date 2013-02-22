<?php
/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)) . '/services/VKontakteOAuthService.php';

class CustomVKontakteService extends VKontakteOAuthService
{

    // protected $scope = 'friends';

    protected function fetchAttributes()
    {
        $info = (array)$this->makeSignedRequest(
            'https://api.vk.com/method/users.get.json',
            array(
                'query' => array(
                    'uids'   => $this->uid,
                    //'fields' => '', // uid, first_name and last_name is always available
                    #'fields' => 'nickname, sex, bdate, city, country, timezone, photo, photo_medium, photo_big, photo_rec',
                    'fields' => 'nickname, sex, bdate, city, country, photo, photo_big, contacts',
                ),
            )
        );

        $info                             = $info['response'][0];
        $this->attributes['id']           = $info->uid;
        $this->attributes['access_token'] = $this->access_token;

        $this->attributes['firstname']  = $info->first_name;
        $this->attributes['lastname']   = $info->last_name;
        $this->attributes['username']   = !empty($info->nickname) ? $info->nickname : $info->first_name;
        $this->attributes['sex']        = $info->sex == 1 ? 2 : 1;
        $this->attributes['birth_date'] = $info->bdate;
        $this->attributes['country']    = $info->country;
        $this->attributes['city']       = $info->city;
        $this->attributes['phone']      = !empty($info->contacts->mobile_phone) ? $info->contacts->mobile_phone : '';
        $this->attributes['avatar']     = $info->photo;
        $this->attributes['photo']      = $info->photo_big;
    }
}

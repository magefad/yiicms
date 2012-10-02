<?php
/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)) . '/services/GoogleOpenIDService.php';

class CustomGoogleService extends GoogleOpenIDService
{

    //protected $jsArguments = array('popup' => array('width' => 450, 'height' => 450));

    protected $requiredAttributes = array(
        'firstname' => array('firstname', 'namePerson/first'),
        'lastname'  => array('lastname', 'namePerson/last'),
        'email'     => array('email', 'contact/email'),
        'country'   => array('country', 'contact/country/home'),
        #'language'  => array('language', 'pref/language'),
    );

    protected function fetchAttributes()
    {
        $this->attributes['username'] = $this->attributes['name'] . ' ' . $this->attributes['lastname'];
        $this->attributes['country'] = $this->attributes['country'] == 'RU' ? 'Россия' : $this->attributes['country'];
    }
}

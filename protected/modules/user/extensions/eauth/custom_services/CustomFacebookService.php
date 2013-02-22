<?php
class CustomFacebookService extends FacebookOAuthService
{
    /**
     * https://developers.facebook.com/docs/authentication/permissions/
     */
    protected $scope = 'user_birthday,user_hometown,user_location,user_photos,email';

    /**
     * http://developers.facebook.com/docs/reference/api/user/
     * @see FacebookOAuthService::fetchAttributes()
     */
    protected function fetchAttributes()
    {
        $info                             = (object)$this->makeSignedRequest('https://graph.facebook.com/me');
        $this->attributes['id']           = $info->id;
        $this->attributes['access_token'] = $this->access_token;

        $this->attributes['firstname']  = $info->first_name;
        $this->attributes['lastname']   = $info->last_name;
        $this->attributes['username']   = !empty($info->username) ? $info->username : $info->first_name;
        $this->attributes['sex']        = $info->gender == 'male' ? 1 : 2;
        $this->attributes['birth_date'] = $info->birthday;
        $this->attributes['country']    = $info->country;
        $this->attributes['city']       = $info->hometown;
        $this->attributes['avatar']     = $info->cover;
        $this->attributes['email']      = $info->email;
    }
}

<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
     * @var int User id
     */
    private $_id;

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        /** @var $user User */
        $user = User::model()->findByAttributes(array('username' => $this->username));
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if (!$user->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id      = $user->id;
            $this->username = $user->username;

            $user->last_visit = (strncasecmp(
                'sqlite',
                Yii::app()->db->driverName,
                6
            ) === 0) ? new CDbExpression("date('now')") : new CDbExpression('NOW()');
            $user->update(array('last_visit'));

            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    /**
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->_id;
    }
}

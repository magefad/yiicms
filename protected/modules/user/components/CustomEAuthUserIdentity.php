<?php

class CustomEAuthUserIdentity extends EAuthUserIdentity
{
    /**
     * Constructor.
     * @param EAuthServiceBase $service the authorization service instance.
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * Authenticates a user based on {@link service}.
     * This method is required by {@link IUserIdentity}.
     * @throws CDbException
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        if ($this->service->isAuthenticated) {
            $this->id   = $this->service->getId();
            $this->name = $this->service->getAttribute('name');

            /** @var $userSocial UserSocial */
            $userSocial = UserSocial::model()->findByServiceId($this->id, $this->service->serviceName);
            // This is First Log-in!
            if (!$userSocial) {
                $attributes = $this->service->getAttributes();
                $user = new User();
                $user->setAttributes(
                    array(
                        'firstname'     => $attributes['firstname'],
                        'lastname'      => $attributes['lastname'],
                        'username'      => $attributes['username'],
                        'sex'           => $attributes['sex'],
                        'birth_date'    => date('Y-m-d', strtotime($attributes['birth_date'])),//@todo why empty?
                        'country'       => $attributes['country'],
                        'city'          => $attributes['city'],
                        'phone'         => $attributes['phone'],
                        #'status'        => 'not_active',
                        'access_status' => User::ACCESS_LEVEL_USER,
                        'photo'         => $attributes['photo'],
                        'avatar'        => $attributes['avatar'],
                        'email_confirm' => false
                    )
                );
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if (!$user->save(false)) {
                        throw new CDbException(Yii::t('user', 'Error when saving User' . print_r($user->getErrors())));
                    } else {
                        $userSocial = new UserSocial();
                        $userSocial->setAttributes(
                            array(
                                'id'             => $this->id,
                                'user_id'        => $user->id, //last insert id
                                'service'        => $this->service->serviceName,
                                'access_token'   => $attributes['access_token']
                            )
                        );
                        if (isset($attributes['email'])) {
                            $userSocial->setAttribute('email', $attributes['email']);
                        }

                        if (!$userSocial->save()) {
                            throw new CDbException(Yii::t('user', 'Error when saving UserSocial' . print_r($userSocial->getErrors())));
                        }
                        $transaction->commit();
                        $this->name = $user->username;
                        Yii::app()->user->setState('id', $user->id);
                        $this->errorCode = self::ERROR_NONE;
                    }
                } catch ( Exception $e ) {
                    $transaction->rollback();
                    Yii::log(
                        'Error when FIRST login through social!' . $this->service->serviceName,
                        CLogger::LEVEL_ERROR
                    );
                    Yii::app()->user->setFlash(
                        'error',
                        Yii::t(
                            'user',
                            'При создании учетной записи произошла ошибка {error}!',
                            array('{error}' => $e->getMessage())
                        )
                    );
                    $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
                }
            } else { //UserSocial founded in DB, found user and log-in
                $this->name = $userSocial->user->username;
                Yii::app()->user->setState('id', $userSocial->user->id);//@todo Yii::app()->user->id
                $userSocial->user->last_visit = (strncasecmp(
                    'sqlite',
                    Yii::app()->db->driverName,
                    6
                ) === 0) ? new CDbExpression("date('now')") : new CDbExpression('NOW()');
                $userSocial->user->update(array('last_visit'));
                $this->errorCode = self::ERROR_NONE;
            }
        } else {
            $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
        }
        return !$this->errorCode;
    }
}

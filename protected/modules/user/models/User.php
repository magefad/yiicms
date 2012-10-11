<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $create_time
 * @property string $update_time
 * @property string $firstname
 * @property string $lastname
 * @property string $username
 * @property string $sex
 * @property string $birth_date
 * @property string $country
 * @property string $city
 * @property string $phone
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property integer $status
 * @property integer $access_level
 * @property string $last_visit
 * @property string $registration_date
 * @property string $registration_ip
 * @property string $activation_ip
 * @property string $photo
 * @property string $avatar
 * @property integer $use_gravatar
 * @property string $activate_key
 * @property integer $email_confirm
 *
 * The followings are the available model relations:
 * @property Blog[] $blogs
 * @property Blog[] $blogsUpdate
 * @property Post[] $blogPosts
 * @property Post[] $blogPostsUpdate
 * @property Photo[] $galleryPhotos
 * @property Photo[] $galleryPhotosUpdate
 * @property News[] $news
 * @property Page[] $pages
 * @property Page[] $pagesUpdate
 * @property UserBlog[] $userBlogs
 */
class User extends CActiveRecord
{
    const STATUS_ACTIVE     = 1;
    const STATUS_BLOCK      = 0;
    const STATUS_NOT_ACTIVE = 2;

    const EMAIL_CONFIRM_YES = 1;
    const EMAIL_CONFIRM_NO  = 0;

    const ACCESS_LEVEL_USER  = 0;
    const ACCESS_LEVEL_ADMIN = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('username, firstname, lastname, email', 'filter', 'filter' => 'trim'),
            array(
                'username, firstname, lastname, email',
                'filter',
                'filter' => array($obj = new CHtmlPurifier(), 'purify')
            ),
            array('username, email', 'required'),
            array('status, access_level, use_gravatar, email_confirm', 'numerical', 'integerOnly' => true),
            array('firstname, lastname, username, email', 'length', 'max' => 150),
            array('sex', 'length', 'max' => 1),
            array('country, city, password, salt, activate_key', 'length', 'max' => 32),
            array('registration_ip, activation_ip', 'length', 'max' => 20),
            array('photo, avatar', 'length', 'max' => 100),
            array('last_visit', 'safe'),
            array('email_confirm', 'in', 'range' => array_keys($this->getEmailConfirmStatusList())),
            array('use_gravatar', 'in', 'range' => array(0, 1)),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('access_level', 'in', 'range' => array_keys($this->getAccessLevelsList())),
            array(
                'username',
                'match',
                'pattern' => '/^[A-Za-z0-9]{2,50}$/',
                'message' => Yii::t(
                    'user',
                    'Неверный формат поля "{attribute}" допустимы только буквы и цифры, от 2 до 20 символов'
                )
            ),
            array('email', 'email'),
            array('email', 'unique', 'message' => Yii::t('user', 'Данный email уже используется другим пользователем')),
            array(
                'username',
                'unique',
                'message' => Yii::t('user', 'Данный логин уже используется другим пользователем')
            ),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
                'id, create_time, update_time, firstname, lastname, username, sex, birth_date, country, city, phone, email, password, salt, status, access_level, last_visit, registration_date, registration_ip, activation_ip, photo, avatar, use_gravatar, activate_key, email_confirm',
                'safe',
                'on' => 'search'
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'blogs'               => array(self::HAS_MANY, 'Blog', 'create_user_id'),
            'blogsUpdate'         => array(self::HAS_MANY, 'Blog', 'update_user_id'),
            'blogPosts'           => array(self::HAS_MANY, 'BlogPost', 'create_user_id'),
            'blogPostsUpdate'     => array(self::HAS_MANY, 'BlogPost', 'update_user_id'),
            'galleryPhotos'       => array(self::HAS_MANY, 'GalleryPhoto', 'create_user_id'),
            'galleryPhotosUpdate' => array(self::HAS_MANY, 'GalleryPhoto', 'update_user_id'),
            'news'                => array(self::HAS_MANY, 'News', 'create_user_id'),
            'newsUpdate'          => array(self::HAS_MANY, 'News', 'update_user_id'),
            'pages'               => array(self::HAS_MANY, 'Page', 'create_user_id'),
            'pagesUpdate'         => array(self::HAS_MANY, 'Page', 'update_user_id'),
            'recoveryPasswords'   => array(self::HAS_MANY, 'RecoveryPassword', 'user_id'),
            'userBlogs'           => array(self::HAS_MANY, 'UserBlog', 'user_id'),
            'userSocial'          => array(self::HAS_MANY, 'UserIdentity', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                => Yii::t('user', 'ID'),
            'create_time'       => Yii::t('user', 'Дата активации'),
            'update_time'       => Yii::t('user', 'Дата изменения'),
            'firstname'         => Yii::t('user', 'Имя'),
            'lastname'          => Yii::t('user', 'Фамилия'),
            'username'          => Yii::t('user', 'Логин'),
            'sex'               => Yii::t('user', 'Пол'),
            'birth_date'        => Yii::t('user', 'День рождения'),
            'country'           => Yii::t('user', 'Страна'),
            'city'              => Yii::t('user', 'Город'),
            'phone'             => Yii::t('user', 'Телефон'),
            'email'             => Yii::t('user', 'Email'),
            'password'          => Yii::t('user', 'Пароль'),
            'salt'              => Yii::t('user', 'Соль'),
            'status'            => Yii::t('user', 'Статус'),
            'access_level'      => Yii::t('user', 'Доступ'),
            'last_visit'        => Yii::t('user', 'Последний визит'),
            'registration_date' => Yii::t('user', 'Дата регистрации'),
            'registration_ip'   => Yii::t('user', 'IP регистрации'),
            'activation_ip'     => Yii::t('user', 'IP активации'),
            'activate_key'      => Yii::t('user', 'Код активации'),
            'photo'             => Yii::t('user', 'Фото'),
            'avatar'            => Yii::t('user', 'Аватар'),
            'use_gravatar'      => Yii::t('user', 'Граватар'),
            'email_confirm'     => Yii::t('user', 'Email подтвержден'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('firstname', $this->firstname, true);
        $criteria->compare('lastname', $this->lastname, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('sex', $this->sex, true);
        $criteria->compare('birth_date', $this->birth_date, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('access_level', $this->access_level);
        $criteria->compare('last_visit', $this->last_visit, true);
        $criteria->compare('registration_date', $this->registration_date, true);
        $criteria->compare('registration_ip', $this->registration_ip, true);
        $criteria->compare('activation_ip', $this->activation_ip, true);
        $criteria->compare('photo', $this->photo, true);
        $criteria->compare('avatar', $this->avatar, true);
        $criteria->compare('use_gravatar', $this->use_gravatar);
        $criteria->compare('activate_key', $this->activate_key, true);
        $criteria->compare('email_confirm', $this->email_confirm);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return bool
     */
    public function beforeSave()
    {
        unset($this->update_time);//on update CURRENT_TIMESTAMP
        if ($this->isNewRecord) {
            $this->registration_date = $this->create_time = new CDbExpression('NOW()');
            $this->activate_key      = $this->generateActivationKey();
            $this->registration_ip   = $this->activation_ip = Yii::app()->request->userHostAddress;
        }
        return parent::beforeSave();
    }

    /**
     * @return array
     */
    public function scopes()
    {
        return array(
            'active'       => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_ACTIVE)
            ),
            'blocked'      => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_BLOCK)
            ),
            'notActivated' => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_NOT_ACTIVE)
            ),
            'admin'        => array(
                'condition' => 'access_level = :access_level',
                'params'    => array(':access_level' => self::ACCESS_LEVEL_ADMIN)
            ),
            'user'         => array(
                'condition' => 'access_level = :access_level',
                'params'    => array(':access_level' => self::ACCESS_LEVEL_USER)
            ),
        );
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        if ($this->password === $this->hashPassword($password, $this->salt)) {
            return true;
        }
        return false;
    }

    public function getAccessLevel()
    {
        $data = $this->getAccessLevelsList();
        return array_key_exists($this->access_level, $data) ? $data[$this->access_level] : Yii::t('user', 'нет');
    }

    public function getAccessLevelsList()
    {
        return array(
            self::ACCESS_LEVEL_ADMIN => Yii::t('user', 'Администратор'),
            self::ACCESS_LEVEL_USER  => Yii::t('user', 'Пользователь')
        );
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE     => Yii::t('user', 'Активен'),
            self::STATUS_BLOCK      => Yii::t('user', 'Заблокирован'),
            self::STATUS_NOT_ACTIVE => Yii::t('user', 'Не активирован')
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return array_key_exists($this->status, $data) ? $data[$this->status] : Yii::t('user', 'нет статуса');
    }

    public function getEmailConfirmStatusList()
    {
        return array(
            self::EMAIL_CONFIRM_YES => Yii::t('user', 'Да'),
            self::EMAIL_CONFIRM_NO  => Yii::t('user', 'Нет'),
        );
    }

    public function getEmailConfirmStatus()
    {
        $data = $this->getEmailConfirmStatusList();
        return isset($data[$this->email_confirm]) ? $data[$this->email_confirm] : Yii::t('user', 'неизвестно');
    }

    /**
     * @param $password
     * @param $salt
     * @return string md5 password
     */
    public function hashPassword($password, $salt)
    {
        return md5($salt . $password);
    }

    /**
     * @return string salt
     */
    public function generateSalt()
    {
        return md5(uniqid('', true) . time());
    }

    /**
     * @return string
     */
    public function generateRandomPassword( /*$length = null*/)
    {
        return substr(md5(uniqid(mt_rand(), true) . time()), 0);
    }

    /**
     * @return string
     */
    public function generateActivationKey()
    {
        return md5(time() . $this->email . uniqid());
    }

    /**
     * User avatar
     * @param int $size
     * @param array $htmlOptions
     * @return string
     */
    public function getAvatar($size = 64, $htmlOptions = array())
    {
        if ($this->use_gravatar && $this->email) {
            return CHtml::image(
                'http://grAvatar.com/avatar/' . md5($this->email) . "?d=mm&s=" . $size,
                $this->username,
                $htmlOptions
            );
        } else {
            return '';
        }
    }

    /**
     * @param string $separator
     * @return string lastName firstName or username
     */
    public function getFullName($separator = ' ')
    {
        return $this->firstname || $this->lastname ? $this->lastname . $separator . $this->firstname : $this->username;
    }

    /**
     * @param $password
     * @return bool
     */
    public function changePassword($password)
    {
        $this->password = $this->hashPassword($password, $this->salt);
        return $this->update(array('password'));
    }

    /**
     * @return bool
     */
    public function activate()
    {
        $this->activation_ip = Yii::app()->request->userHostAddress;
        $this->status        = self::STATUS_ACTIVE;
        $this->email_confirm = self::EMAIL_CONFIRM_YES;

        return $this->save();
    }

    public function assignAdminRole($userId)
    {
        $assignmentTable = Yii::app()->authManager->assignmentTable;
        Yii::app()->db->createCommand(
            "INSERT INTO {$assignmentTable} (`itemname`,`userid`,`bizrule`,`data`)
                									VALUES ('Admin','{$userId}', NULL, 'N;')"
        )->execute();
    }

    public function revokeAdminRole($userId)
    {
        $assignmentTable = Yii::app()->authManager->assignmentTable;
        Yii::app()->db->createCommand(
            "DELETE FROM {$assignmentTable} WHERE `userid`={$userId} AND `itemname`='Admin'"
        )->execute();
    }
}

<?php

class CommentModule extends WebModule
{
    /**
     * @var string attribute which holds the ID of the user in {@see $userModelClass}
     */
    public $modelAuthorAttribute = 'create_user_id';

    /**
     * @var string attribute which holds the name of the user in {@see $userModelClass}
     */
    public $usernameAttribute = 'username';

    /**
     * @var string attribute which holds the email of the user in {@see $userModelClass}
     */
    public $userEmailAttribute = 'email';

    public $defaultCommentStatus = 'approved';
    public $notify = true;
    public $notifyEmail;

    public static function getAdminLink()
    {
        return array('icon' => self::getIcon(), 'label' => self::getName(), 'url' => array('/comment/default/admin'));
    }

    public static function getName()
    {
        return Yii::t('CommentModule.comment', 'Comments');
    }

    public static function getIcon()
    {
        return 'comment';
    }

    public function init()
    {
        //parent::init();
        $this->setImport(
            array(
                'comment.models.*',
                'comment.behaviors.*'
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
            $controller->menu = self::getAdminMenu();
            return true;
        } else {
            return false;
        }
    }
}

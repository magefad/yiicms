<?php

class CommentModule extends WebModule
{
    /**
     * @var string attribute which holds the name of the user in {@see $userModelClass}
     */
    public $usernameAttribute = 'username';
    /**
     * @var string attribute which holds the email of the user in {@see $userModelClass}
     */
    public $userEmailAttribute = 'email';

    public $defaultCommentStatus = Comment::STATUS_APPROVED;
    public $notify = true;
    public $notifyEmail;

    public function getIcon()
    {
        return 'comment';
    }

    public function init()
    {
        parent::init();
        $this->setImport(
            array(
                'comment.models.*',
                'comment.behaviours.*',
            )
        );
    }
}

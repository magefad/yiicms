<?php

class CommentBehavior extends CActiveRecordBehavior
{

    public function attach($owner)
    {
        parent::attach($owner);
        // make sure comment module is loaded so views can be rendered properly
        Yii::app()->getModule('comment');
    }

    /**
     * @return CommentModule
     */
    public function getModule()
    {
        return Yii::app()->getModule('comment');
    }

    /**
     * returns a new comment instance that is related to the model this behavior is attached to
     *
     * @return Comment
     * @throws CException
     */
    public function getCommentInstance()
    {
        /** @var $comment Comment */
        $comment           = Yii::createComponent('application.modules.comment.models.Comment');
        $comment->model    = get_class($this->owner);
        $comment->model_id = $this->owner->primaryKey;
        return $comment;
    }

    /**
     * get all related comments for the model this behavior is attached to
     *
     * @return Comment[]
     * @throws CException
     */
    public function getComments()
    {
        $comments = Yii::createComponent('application.modules.comment.models.Comment')->findAll($this->getCommentCriteria());
        return $comments;
    }

    /**
     * count all related comments for the model this behavior is attached to
     *
     * @return int
     * @throws CException
     */
    public function getCommentCount()
    {
        return Yii::createComponent('application.modules.comment.models.Comment')->count($this->getCommentCriteria());
    }

    /**
     * @return CDbCriteria
     */
    protected function getCommentCriteria()
    {
        // @todo: add support for composite pks
        return new CDbCriteria(array(
            'condition' => "t.model=:model AND t.model_id=:model_id",
            'params'    => array(
                ':model'    => get_class($this->owner),
                ':model_id' => $this->owner->getPrimaryKey(),
            )
        ));
    }

    /**
     * @todo this should be moved to a controller or widget
     *
     * @return CArrayDataProvider
     */
    public function getCommentDataProvider()
    {
        return new CArrayDataProvider($this->getComments(), array('sort' => array('attributes' => array('create_time'))));
    }
}

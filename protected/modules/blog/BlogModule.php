<?php
/**
 * User: fad
 * Date: 24.09.12
 * Time: 11:41
 */
class BlogModule extends WebModule
{
    public function getName()
    {
        return Yii::t('blog', 'Blogs');
    }

    public function getDescription()
    {
        return Yii::t('blog', 'Manage blogs, posts and members');
    }

    public function getIcon()
    {
        return 'pencil';
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            array('blog.models.*')
        );
    }
}

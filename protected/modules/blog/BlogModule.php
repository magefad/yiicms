<?php
/**
 * User: fad
 * Date: 24.09.12
 * Time: 11:41
 */
class BlogModule extends WebModule
{
    public static function getAdminLink()
    {
        return array('icon' => self::getIcon(), 'label' => self::getName(), 'url' => array('/blog/default/admin'));
    }

    public function getName()
    {
        return Yii::t('BlogModule.blog', 'Blogs');
    }

    public function getDescription()
    {
        return Yii::t('BlogModule.blog', 'Manage blogs, posts and members');
    }

    public function getIcon()
    {
        return 'pencil';
    }

    public function getAdminMenu()
    {
        $menu = array(
            array(
                'icon'  => 'list-alt',
                'label' => Yii::t('BlogModule.blog', 'Blogs'),
                'url'   => array('/blog/default/admin')
            ),
            array('icon'  => 'file',
                  'label' => Yii::t('BlogModule.blog', 'Create'),
                  'url'   => array('/blog/default/create')
            ),
            array(
                'icon'  => 'list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage Posts'),
                'url'   => array('/blog/post/admin')
            ),
            array('icon'  => 'file',
                  'label' => Yii::t('BlogModule.blog', 'Create Post'),
                  'url'   => array('/blog/post/create')
            ),
            array(
                'icon'  => 'list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage Users'),
                'url'   => array('/blog/userBlog/admin')
            )
        );
        if (isset(Yii::app()->controller->actionParams['id'])) {
            $menu[] = array(
                'icon'  => 'pencil',
                'label' => Yii::t('zii', 'Update'),
                'url'   => array(
                    '/' . $this->id . '/' . Yii::app()->controller->id . '/update',
                    'id' => Yii::app()->controller->actionParams['id']
                )
            );
            $menu[] = array(
                'icon'        => 'remove',
                'label'       => Yii::t('zii', 'Delete'),
                'url'         => '#',
                'linkOptions' => array(
                    'submit'  => array(
                        '/' . $this->id . '/' . Yii::app()->controller->id . '/delete',
                        'id' => Yii::app()->controller->actionParams['id']
                    ),
                    'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?')
                )
            );
        }/* else {@todo add settings for blog
            $menu[] = array(
                'icon'  => 'wrench',
                'label' => Yii::t('admin', 'Настройки'),
                'url'   => array('/admin/setting/update/' . $this->id . '/')
            );
        }*/
        return $menu;
    }

    public function init()
    {
        //parent::init();
        $this->setImport(
            array(
                'blog.models.*',
                'application.modules.comment.models.*'
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
            if (!in_array($action->id, array('show', 'list', 'index'))) {
                $controller->menu = $this->getAdminMenu();
            }
            return true;
        } else {
            return false;
        }
    }
}

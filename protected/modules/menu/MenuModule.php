<?php

class MenuModule extends WebModule
{
    public static function getAdminLink()
    {
        return array('icon' => self::getIcon(), 'label' => self::getName(), 'url' => array('/menu/default/admin'));
    }

    public static function getName()
    {
        return Yii::t('menu', 'Меню');
    }

    public static function getDescription()
    {
        return Yii::t('menu', 'Создание и управление ссылками меню навигации');
    }

    public static function getIcon()
    {
        return 'list';
    }

    public function getAdminMenu()
    {
        $menu = array(
            array('icon' => 'list', 'label' => Yii::t('menu', 'Управление'), 'url' => array('/menu/default/admin')),
            array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить меню'), 'url' => array('create', 'root' => 1)),
            array('icon' => 'file', 'label' => Yii::t('menu', 'Добавить пункт'), 'url' => array('create'))
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
        $this->setImport(array('menu.models.*'));
    }

    /**
     * @param Controller $controller
     * @param CAction $action
     * @return bool
     */
    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            $controller->menu = $this->getAdminMenu();
            return true;
        } else {
            return false;
        }
    }
}

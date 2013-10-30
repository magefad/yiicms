<?php

class CatalogModule extends WebModule
{
    public $template = '_item';

    public static function getAdminLink()
    {
        return array('icon' => self::getIcon(), 'label' => self::getName(), 'url' => array('/catalog/catalogItem/admin'));
    }

    public static function getName()
    {
        return Yii::t('CatalogModule.catalog', 'Catalog');
    }

    public static function getDescription()
    {
        return Yii::t('CatalogModule.catalog', 'Catalog of items');
    }

    public static function getIcon()
    {
        return 'th-large';
    }

    public function init()
    {
        $this->setImport(array('catalog.models.*', 'page.PageModule'));
        parent::init();
    }

    /**
     * @param Controller $controller
     * @param CAction $action
     * @return bool
     */
    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            if ($action->id !== 'show') {
                $controller->menu = self::getAdminMenu();
            }
            return true;
        } else {
            return false;
        }
    }
}

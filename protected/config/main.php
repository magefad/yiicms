<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
    'basePath'          => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'              => 'Fad cms',
    'defaultController' => 'page/default/show',
    #'homeLink'         => '/',
    'sourceLanguage'    => 'en',
    'language'          => 'ru',
    'theme'             => 'reflector',
    // preloading 'log' component
    'preload'           => array('log', 'bootstrap'),
    // autoloading model and component classes
    'import'            => array(
        'application.components.*',
        //module
        'application.modules.user.models.*',
        'application.modules.menu.models.*',
        'application.modules.page.models.*',
        'application.modules.news.models.*',
        'application.modules.contact.models.*',
        'application.modules.gallery.models.*',
        'application.modules.blog.models.*',
        'application.modules.social.models.*',
        'application.modules.admin.models.*',
        // not base
        'application.helpers.*',
        'application.modules.rights.RightsModule',
        'application.modules.rights.rights.*',
        'application.modules.rights.components.*',
        'application.extensions.galleria.*'
    ),
    'modules' => array(
        'user',
        'menu',
        'page',
        'news',
        'contact',
        'gallery',
        'blog',
        'social',
        'admin',
        'rights',
        'gii' => array(
            'class'          => 'system.gii.GiiModule',
            'password'       => 'fad',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'      => array('127.0.0.1', '::1'),
            'generatorPaths' => array('bootstrap.gii'),
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            'class'          => 'RWebUser',
            'loginUrl'       => '/user/account/login',
            'allowAutoLogin' => true,// enable cookie-based authentication
        ),
        'image' => array(
            'class'   => 'ext.image.CImageComponent', #'application.helpers.image.CImageComponent',
            'driver'  => 'GD', // GD or ImageMagick
            #'params' => array('directory' =>'/opt/local/bin'),// ImageMagick setup path
        ),
        'clientScript' => array(
            'packages' => array(
                'jquery'    => array(
                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/jquery/1.7/',
                    'js'      => array('jquery.min.js'),
                ),
                'jquery.ui' => array(
                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.8/',
                    'js'      => array('jquery-ui.min.js'),
                ),
            ),
        ),
        'widgetFactory' => array(
            'widgets' => array(
                'TinyMce'        => require(dirname(__FILE__) . '/tinymce.php'),
                'CJuiDatePicker' => array( // where <WidgetName> is the name of the JUI Widget (Tabs, DatePicker, etc.). Each CJuiWidget used must be declared
                    'scriptUrl'      => '//ajax.googleapis.com/ajax/libs/jqueryui/1.8',
                    'i18nScriptFile' => 'i18n/jquery-ui-i18n.min.js',
                    'themeUrl'       => '//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes',
                ),
            ),
        ),
        'urlManager'  => require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'urlManager.php'),
        'db'          => require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'db.php'),
        'authManager' => array(
            'class'           => 'RDbAuthManager',
            #default is Auth#'defaultRoles' => array('Guest'),
            'itemTable'       => '{{auth_item}}',
            'itemChildTable'  => '{{auth_item_child}}',
            'assignmentTable' => '{{auth_assignment}}',
            'rightsTable'     => '{{rights}}',
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error', // use 'site/error' action to display errors
        ),
        'cache' => array(
            'class' => 'CFileCache',
        ),
        'log' => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                ),
                // uncomment the following to show log messages on web pages
                /*array(
                        'class' => 'CWebLogRoute',
                ),*/
            ),
        ),
        'bootstrap' => array(
            'class'         => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => true,
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'index' => 'index',
    ),
);

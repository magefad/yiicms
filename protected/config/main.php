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
    // preloading 'log' component
    'preload'           => array('log', 'bootstrap'),
    // autoloading model and component classes
    'import'            => array(
        'application.components.*',
        'application.components.behaviors.*',
        'application.modules.user.models.*',
        'application.modules.menu.models.*',
    ),
    'modules'           => array('user', 'menu', 'page', 'news', 'contact', 'gallery', 'blog', 'social', 'comment', 'admin', 'rights'),
    // application components
    'components'        => array(
        'user'          => array(
            'class'          => 'RWebUser',
            'loginUrl'       => '/user/account/login',
            'allowAutoLogin' => true, // enable cookie-based authentication
        ),
        'image'         => array(
            'class'  => 'ext.image.CImageComponent', #'application.helpers.image.CImageComponent',
            'driver' => 'GD', // GD or ImageMagick
            #'params' => array('directory' =>'/opt/local/bin'),// ImageMagick setup path
        ),
        'clientScript'  => array(
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
                'TinyMce'        => array(
                    'compressorRoute'    => 'tinyMce/compressor',
                    'spellcheckerRoute'  => 'tinyMce/spellchecker',
                    'fileManager'        => array(
                        'class'          => 'ext.elFinder.TinyMceElFinder',
                        'connectorRoute' => 'elfinder/connector',
                    ),
                    'settings'           => array(
                        'doctype'                         => '<!DOCTYPE html>',
                        'extended_valid_elements'         => 'iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]',
                        'body_class'                      => 'container-fluid',
                        'width'                           => '100%',
                        'plugins'                         => 'autolink,lists,pagebreak,layer,table,save,advimage,advlink,inlinepopups,insertdatetime,media,searchreplace,contextmenu,paste,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist',
                        'theme_advanced_buttons1'         => "save,|,fullscreen,|,code,|,undo,redo,|,pastetext,pasteword,|,removeformat,cleanup,visualaid,|,attribs,styleprops,charmap,hr,|,link,unlink,anchor,image,|,media,|,insertdate,inserttime,|,preview,|,spellchecker,|,pagebreak",
                        'theme_advanced_buttons2'         => "styleselect,formatselect,fontselect,fontsizeselect,|,bold,italic,underline,strikethrough,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,blockquote",
                        #'theme_advanced_buttons4'        => "insertlayer,moveforward,movebackward,absolute,|,cite,abbr,acronym,del,ins|,visualchars,nonbreaking,template,pagebreak",
                        'theme_advanced_buttons3'         => "",
                        'theme_advanced_buttons4'         => "",
                        'theme_advanced_toolbar_location' => "top",
                        'theme_advanced_toolbar_align'    => "left",
                        'external_link_list_url'          => '/page/default/MceListUrl',
                        'relative_urls'                   => false,
                        'pagebreak_separator'             => '<cut>',
                    ),
                ),
                'CJuiDatePicker' => array( // where <WidgetName> is the name of the JUI Widget (Tabs, DatePicker, etc.). Each CJuiWidget used must be declared
                    'scriptUrl'      => '//ajax.googleapis.com/ajax/libs/jqueryui/1.8',
                    'i18nScriptFile' => 'i18n/jquery-ui-i18n.min.js',
                    'themeUrl'       => '//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes',
                ),
            ),
        ),
        'urlManager'    => require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'urlManager.php'),
        'authManager'   => array(
            'class'           => 'RDbAuthManager',
            #default is Auth#'defaultRoles' => array('Guest'),
            'itemTable'       => '{{auth_item}}',
            'itemChildTable'  => '{{auth_item_child}}',
            'assignmentTable' => '{{auth_assignment}}',
            'rightsTable'     => '{{rights}}',
        ),
        'errorHandler'  => array(
            'errorAction' => 'site/error', // use 'site/error' action to display errors
        ),
        'cache'         => array(
            'class' => 'CFileCache',
        ),
        'log'        => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                ),
            ),
        ),
        'bootstrap'     => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            //'responsiveCss' => true,
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    /*'params' => array(

    ),*/
);

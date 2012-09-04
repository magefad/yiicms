<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

define('JUI-THEME', 'dark-hive');
return array(
	'basePath'          => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name'              => 'Fad cms',
	'defaultController' => 'page/show',
	#'homeLink'=> '/',
	'language'          => 'ru',
	'theme'             => 'reflector',
	// preloading 'log' component
	'preload'           => array('log', 'bootstrap'),

	// autoloading model and component classes
	'import'            => array(
		'application.models.*',
		'application.components.*',
		// notbase
		'application.helpers.*',
		'application.modules.rights.RightsModule',
		'application.modules.rights.rights.*',
		'application.modules.rights.components.*',
		'application.extensions.galleria.*'
	),

	'modules'           => array(
		'gii'       => array(
			'class'         => 'system.gii.GiiModule',
			'password'      => 'fad',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'     => array('127.0.0.1', '::1'),
			'generatorPaths'=> array('bootstrap.gii'),
		), 'rights' => array(
			'superuserName'         => 'Admin', // Name of the role with super user privileges.
			'authenticatedName'     => 'Authenticated', // Name of the authenticated user role.
			#'userIdColumn'     => 'id', // Name of the user id column in the database.
			#'userNameColumn'   => 'username', // Name of the user name column in the database.
			'enableBizRule'         => true, // Whether to enable authorization item business rules.
			'enableBizRuleData'     => false, // Whether to enable data for business rules.
			'displayDescription'    => true, // Whether to use item description instead of name.
			'flashSuccessKey'       => 'RightsSuccess', // Key to use for setting success flash messages.
			'flashErrorKey'         => 'RightsError', // Key to use for setting error flash messages.
			#'install'               => true, // Whether to install rights.
			'baseUrl'               => '/rights', // Base URL for Rights. Change if module is nested.
			'layout'                => 'rights.views.layouts.main', // Layout to use for displaying Rights.
			'appLayout'             => 'application.views.layouts.main', // Application layout.
			#'cssFile'               => 'rights.css', // Style sheet file to use for Rights.
			'debug'                 => false, // Whether to enable debug mode.
		),
	),

	// application components
	'components'        => array(
		'user'             => array(
			'class'          => 'RWebUser', #'loginUrl' 	 => '/site/login/',
			'allowAutoLogin' => true, // enable cookie-based authentication
		),
		'image'            => array(
			'class'    => 'ext.image.CImageComponent', #'application.helpers.image.CImageComponent',
			'driver'   => 'GD', // GD or ImageMagick
			#'params'	=> array('directory'=>'/opt/local/bin'),// ImageMagick setup path
		),
		'clientScript'     => array(
			#'coreScriptPosition' => CClientScript::POS_END,
			'packages' => array(
				'jquery'       => array(
					'baseUrl' => '//ajax.googleapis.com/ajax/libs/jquery/1.7/', 'js'      => array('jquery.min.js'),
				),
				'jquery.ui' => array(
					'baseUrl' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.7/',
					'js'      => array('jquery-ui.min.js'),
				),
			),
		),
		'widgetFactory'    => array(
			'widgets' => array(
				'TinyMce'        => require(dirname(__FILE__) . '/tinymce.php'),
				'CJuiDatePicker' => array( // where <WidgetName> is the name of the JUI Widget (Tabs, DatePicker, etc.). Each CJuiWidget used must be declared
					'scriptUrl'        => '//ajax.googleapis.com/ajax/libs/jqueryui/1.7',
					'i18nScriptFile'   => 'i18n/jquery-ui-i18n.min.js',
					#'theme'           => JUI-THEME,
					'themeUrl'         => '//ajax.googleapis.com/ajax/libs/jqueryui/1.7/themes',
				),
			),
		),
		'urlManager'       => require(dirname(__FILE__) . '/urlManager.php'),
		'db'               => require(dirname(__FILE__) . '/db.php'),
		'authManager'      => array(
			'class'              => 'RDbAuthManager',
			#default is Auth#'defaultRoles' => array('Guest'),
			'itemTable'          => 'fad_auth_item',
			'itemChildTable'     => 'fad_auth_item_child',
			'assignmentTable'    => 'fad_auth_assignment',
			'rightsTable'        => 'fad_rights',
			#'connectionID'	  => 'db',
		),
		'errorHandler'     => array(
			'errorAction' => 'site/error', // use 'site/error' action to display errors
		),
		'cache'            => array(
			'class' => 'CFileCache',
		),
		'log'              => array(
			'class'  => 'CLogRouter',
			'routes' => array(
				array(
					'class'  => 'CFileLogRoute', 'levels' => 'error, warning, info',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class' => 'CWebLogRoute',
				),
				*/
				//профайлер запросов к базе данных, на продакшн серверах рекомендуется отключить
				/*array(
					'class'        => 'application.modules.yupe.extensions.db_profiler.DbProfileLogRoute',
					'countLimit'   => 1, // How many times the same query should be executed to be considered inefficient
					'slowQueryMin' => 0.01, // Minimum time for the query to be slow
				),*/
			),
		),
		'bootstrap'        => array(
			'class'            => 'ext.bootstrap.components.Bootstrap',
			// assuming you extracted bootstrap under extensions
			'responsiveCss'    => true,
		),
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'            => array(
		// this is used in contact page
		'adminEmail'=> 'fad@itrade-rus.ru',
		'cacheTime' => 3600,
		'index'     => 'index',
	),
);
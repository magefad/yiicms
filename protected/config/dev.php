<?php
return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    array(
        'name'       => 'Yii Fad CMS (debug)',
        'modules'    => array(
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
            'db'  => array_merge(
                require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'db.php'),
                array(
                    'enableProfiling'    => true,
                    'enableParamLogging' => true,
                )
            ),
            'authManager' => array(
                'behaviors' => array(
                    'auth' => array(
                        'admins' => array(), // !user names with full access!
                    )
                )
            ),
            'log' => array(
                'class'  => 'CLogRouter',
                'routes' => array(
                    array(
                        'class'  => 'CFileLogRoute',
                        'levels' => 'error, warning, info',
                    ),
                    /*array(
                        'class'        => 'ext.db_profiler.DbProfileLogRoute',
                        'countLimit'   => 1,
                        // How many times the same query should be executed to be considered inefficient
                        'slowQueryMin' => 0.01,
                        // Minimum time for the query to be slow
                    ),*/
                    // uncomment the following to show log messages on web pages
                    /*array(
                        'class' => 'CWebLogRoute',
                        #'showInFireBug' => true
                    ),
                    array(
                        'class'  => 'CProfileLogRoute',
                        'levels' => 'profile',
                    ),*/
                ),
            ),
            'bootstrap'  => array(
                'class'         => 'ext.bootstrap.components.Bootstrap',
                'responsiveCss' => false,
            ),
        ),
    )
);

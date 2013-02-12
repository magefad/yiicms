<?php

// This is the configuration for Install only
$config = CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    array(
        'defaultController' => 'install/default/index',
        'name'              => 'Yii Fad CMS Installation',
        'preload'           => array('bootstrap'),
        'modules'           => array('install'),
        'components'        => array(
            'cache'        => array(
                'class' => 'CDummyCache',
            ),
            'errorHandler' => array(
                'errorAction' => 'install/default/error',
            ),
        ),
    )
);
unset($config['components']['user']);
unset($config['components']['image']);
unset($config['components']['widgetFactory']);
#unset($config['components']['authManager']);
unset($config['components']['log']);
return $config;

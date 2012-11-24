<?php
return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    array(
        'name'       => 'Fad cms',
        'theme'      => 'kotel',
        'components' => array(
            'db' => require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'db.php'),
            'cache'         => array(
                'class' => 'CXCache',
            ),
            'log'        => array(
                'class'  => 'CLogRouter',
                'routes' => array(
                    array(
                        'class'      => 'CEmailLogRoute',
                        'categories' => 'error',
                        'emails'     => array(
                            'mail@' . str_replace('www.', '', $_SERVER['HTTP_HOST']),
                            'subject' => 'Error at ' . $_SERVER['HTTP_HOST']
                        ),
                    ),
                ),
            )
        ),
    )
);
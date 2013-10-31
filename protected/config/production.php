<?php
return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    array(
        'name'       => 'Yii Fad CMS (production)',
        //'theme'      => '',
        'components' => array(
            'db'          => array_merge(
                require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'db.php'),
                array('schemaCachingDuration' => 108000)
            ),
            'user' => array(
                'admins' => array(), // !user names with full access!
            ),
            /*'cache' => array(
                'class' => 'CXCache',
            ),
            'log'   => array(
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
            )*/
        )
    )
);

<?php
return array(
	'urlFormat'         => 'path',
	'showScriptName'    => false,
	'cacheID'           => 'cache',
	'rules'             => array(
		'rights'                                 => 'rights/assignment',
		'gallery'                                => 'gallery/default/list',
		'album/<slug:[\w\_-]+>'                  => 'gallery/photo/album',

		'contact'                                => 'contact/default',
		'about'                                  => 'contact/default',
		'<slug:[\w\_-]+>'                        => 'page/default/show',
		'/news/show/<slug:[\w\_-]+>'            => 'news/default/show',

		#'news/<id:\d+>'                          => 'news/news/view',
		#'news/<action:\w+>/<id:\d+>'             => 'news/news/<action>',
		#'news/<action:\w+>'                      => 'news/news/<action>',
		'<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'   => '<module>/<controller>/<action>',
		'<module:\w+>/<controller:\w+>/<action:\w+>'            => '<module>/<controller>/<action>',
		'<module:\w+>/<controller:\w+>'                         => '<module>/<controller>/index',
		'gii/<controller:\w+>'                   => 'gii/<controller>',
		'gii/<controller:\w+>/<action:\w+>'      => 'gii/<controller>/<action>',
		'<controller:\w+>/<id:\d+>'              => '<controller>/view',
		'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
		'<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
	),
)
?>
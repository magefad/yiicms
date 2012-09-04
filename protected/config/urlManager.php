<?php
return array(
	'urlFormat'         => 'path',
	'showScriptName'    => false,
	'cacheID'           => 'cache',
	'rules'             => array(
		'rights'                                 => 'rights/assignment',
		'gallery'                                => 'gallery/list',
		'album/<slug:[\w\_-]+>'                  => 'galleryPhoto/album',
		'photo/<id:\d+>'                         => 'galleryPhoto/view',
		'photo/<action:\w+>/<id:\d+>'            => 'galleryPhoto/<action>',
		'photo/<action:\w+>'                     => 'galleryPhoto/<action>',

		'about'                                  => 'site/contact',
		'<slug:[\w\_-]+>'                        => 'page/show',
		'/news/show/<title:[\w\_-]+>'            => 'news/show',
		'<controller:\w+>/<id:\d+>'              => '<controller>/view',
		'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
		'<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
		'gii'                                    => 'gii',
		'gii/<controller:\w+>'                   => 'gii/<controller>',
		'gii/<controller:\w+>/<action:\w+>'      => 'gii/<controller>/<action>',
	),
)
?>
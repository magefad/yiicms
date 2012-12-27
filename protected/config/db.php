<?php
//return DB settings for production mode
return array(
	'connectionString'      => 'mysql:host=localhost;dbname=fadcms',
	'emulatePrepare'        => true,
	'username'              => 'root',
	'password'              => '',
	'charset'               => 'utf8',
	'tablePrefix'           => 'fad_',
	'schemaCachingDuration' => 108000,
);
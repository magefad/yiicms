<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
/**
 * INSTALL FROM CONSOLE
 * 1. Install required modules (user with RBAC, menu and page):
 *      yiic migrate up --module=user,admin,menu,page,news
 * 2. Other modules if needed
 *      yiic migrate up --module=MODULE1,MODULE2,...
 * All additional modules:
 *      yiic migrate up --module=gallery,blog,comment,social
 */

/**
 * REMOVE
 * 1. Remove all additional modules:
 *      yiic migrate to m000000_000000 --module=news,gallery,blog,comment,social
 * 2. Remove required modules
 *      yiic migrate to m000000_000000 --module=admin,page,menu
 *      yiic migrate to m000000_000000 --module=user
 */

$modules_dirs = scandir(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules');
foreach ($modules_dirs as $module) {
    if ($module[0] == '.') {
        continue;
    }
    $modules[] = $module;
}
$components = array();
if (file_exists(dirname(__FILE__) . '/protected/config/db.php')) {
    $components['db'] = require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'db.php');
}
return array(
    'basePath'   => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'       => 'Yii Fad CMS console',
    'modules'    => $modules,
    'components' => $components,
    'commandMap' => array(
        'migrate' => array(
            'class'          => 'ext.migrate-command.EMigrateCommand',
            'migrationTable' => '{{migration}}',
            'modulePaths'    => array(
                'user'    => 'application.modules.user.migrations',
                'menu'    => 'application.modules.menu.migrations',
                'page'    => 'application.modules.page.migrations',
                'news'    => 'application.modules.news.migrations',
                'gallery' => 'application.modules.gallery.migrations',
                'blog'    => 'application.modules.blog.migrations',
                'comment' => 'application.modules.comment.migrations',
                'social'  => 'application.modules.social.migrations',
                'admin'   => 'application.modules.admin.migrations',
            ),
        ),
    )
);
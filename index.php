<?php
date_default_timezone_set('Europe/Moscow');

$webRoot = dirname(__FILE__);
if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
    define('YII_DEBUG', true);
    define('YII_TRACE_LEVEL', 3);
    require_once($webRoot . '/../../../framework/yii.php');
    $config = $webRoot . '/protected/config/dev.php';
}
else {
    require_once($webRoot . '/../private/framework/yii.php');
    $config = $webRoot . '/protected/config/production.php';
}
Yii::createWebApplication($config)->run();

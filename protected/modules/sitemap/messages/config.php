<?php
/**
 * Config for Translate Yii::t messages
 *
 * Example use (Windows):
 * Open CMD -> cd PATH_TO_PROTECTED_FOLDER -> enter "yiic message modules/sitemap/messages/config.php"
 */
return array(
    'sourcePath'  => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR,
    'messagePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'messages',
    'languages'   => array('en', 'ru'),
    'fileTypes'   => array('php'),
    'overwrite'   => true,
    'removeOld'   => true,
    'sort'        => true,
);

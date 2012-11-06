<?php
/**
 * Config for Translate Yii::t messages
 *
 * Example use (Windows):
 * Open CMD -> cd PATH_TO_MODULE_FOLDER -> enter "yiic message messages\config.php"
 * @author Fadeev Ruslan
 * Date: 25.09.12
 * Time: 13:25
 */
return array(
    'sourcePath'  => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'messagePath' => dirname(__FILE__),
    'languages'   => array('en', 'ru'),
    'fileTypes'   => array('php'),
    'overwrite'   => true,
    'removeOld'   => true,
    'sort'        => true,
);

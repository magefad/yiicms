<?php
/**
 * Config for Translate Yii::t messages
 *
 * Example use (Windows):
 * Open CMD -> cd PATH_TO_PROTECTED_FOLDER -> enter "yiic message modules/install/messages/config.php"
 */

return array(
    'sourcePath'  => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR,
    'messagePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'messages',
    #'languages'   => array('zh_cn','zh_tw','de','es','el','sv','he','nl','pt','ru','it','fr','ja','pl','ro','id','vi','bg','uk','cs', 'ar','de_de','no','pt_br','sk','ta_in'),
    'languages'   => array('en','ru'),
    'fileTypes'   => array('php'),
    'overwrite'   => true,
    'removeOld'   => true,
    #'sort'        => true,
);

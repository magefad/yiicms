<?php
/**
 * config.php class file.
 *
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
/** @var $fileWriteErrors array */

foreach ($fileWriteErrors as $fileName => $data) {
    echo '<div class="alert in alert-block fade alert-error">';
    echo Yii::t('InstallModule.main', 'Error writing to /protected/config/{fileName}.php', array('{fileName}' => $fileName));
    echo '</div>';
    echo CHtml::textArea($fileName, $data);
}
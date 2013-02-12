<?php
/**
 * RequirementsHelperHelper.php class file.
 *
 * Its an implementation of Yii Requirement Checker script
 * @link https://github.com/yiisoft/yii/blob/master/requirements/index.php
 *
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

class InstallHelper
{
    /**
     * Function from yii requirements
     * @return array
     */
    public static function checkRequirements()
    {
        $linkYii = '<a href="http://www.yiiframework.com">Yii Framework</a>';
        $requirements = array(
            array(
                Yii::t('InstallModule.yii', 'PHP version'),
                true,
                version_compare(PHP_VERSION,"5.1.0",">="),
                $linkYii,
                Yii::t('InstallModule.yii', 'PHP 5.1.0 or higher is required.')),
            array(
                Yii::t('InstallModule.yii', '$_SERVER variable'),
                true,
                '' === $message=self::checkServerVar(),
                $linkYii,
                $message),
            array(
                Yii::t('InstallModule.yii', 'Reflection extension'),
                true,
                class_exists('Reflection',false),
                $linkYii,
                ''),
            array(
                Yii::t('InstallModule.yii', 'PCRE extension'),
                true,
                extension_loaded("pcre"),
                $linkYii,
                ''),
            array(
                Yii::t('InstallModule.yii', 'SPL extension'),
                true,
                extension_loaded("SPL"),
                $linkYii,
                ''),
            array(
                Yii::t('InstallModule.yii', 'DOM extension'),
                false,
                class_exists("DOMDocument",false),
                '<a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>, <a href="http://www.yiiframework.com/doc/api/CWsdlGenerator">CWsdlGenerator</a>',
                ''),
            array(
                Yii::t('InstallModule.yii', 'PDO extension'),
                false,
                extension_loaded('pdo'),
                Yii::t('InstallModule.yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
                ''),
            array(
                Yii::t('InstallModule.yii', 'PDO SQLite extension'),
                false,
                extension_loaded('pdo_sqlite'),
                Yii::t('InstallModule.yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
                Yii::t('InstallModule.yii', 'This is required if you are using SQLite database.')),
            array(
                Yii::t('InstallModule.yii', 'PDO MySQL extension'),
                false,
                extension_loaded('pdo_mysql'),
                Yii::t('InstallModule.yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
                Yii::t('InstallModule.yii', 'This is required if you are using MySQL database.')),
            array(
                Yii::t('InstallModule.yii', 'PDO PostgreSQL extension'),
                false,
                extension_loaded('pdo_pgsql'),
                Yii::t('InstallModule.yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
                Yii::t('InstallModule.yii', 'This is required if you are using PostgreSQL database.')),
            array(
                Yii::t('InstallModule.yii', 'PDO Oracle extension'),
                false,
                extension_loaded('pdo_oci'),
                Yii::t('InstallModule.yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
                Yii::t('InstallModule.yii', 'This is required if you are using Oracle database.')),
            array(
                Yii::t('InstallModule.yii', 'PDO MSSQL extension (pdo_mssql)'),
                false,
                extension_loaded('pdo_mssql'),
                Yii::t('InstallModule.yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
                Yii::t('InstallModule.yii', 'This is required if you are using MSSQL database from MS Windows')),
            array(
                Yii::t('InstallModule.yii', 'PDO MSSQL extension (pdo_dblib)'),
                false,
                extension_loaded('pdo_dblib'),
                Yii::t('InstallModule.yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
                Yii::t('InstallModule.yii', 'This is required if you are using MSSQL database from GNU/Linux or other UNIX.')),
            array(
                Yii::t('InstallModule.yii', 'PDO MSSQL extension (<a href="http://sqlsrvphp.codeplex.com/">pdo_sqlsrv</a>)'),
                false,
                extension_loaded('pdo_sqlsrv'),
                Yii::t('InstallModule.yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
                Yii::t('InstallModule.yii', 'This is required if you are using MSSQL database with the driver provided by Microsoft.')),
            array(
                Yii::t('InstallModule.yii', 'Memcache extension'),
                false,
                extension_loaded("memcache") || extension_loaded("memcached"),
                '<a href="http://www.yiiframework.com/doc/api/CMemCache">CMemCache</a>',
                extension_loaded("memcached") ? Yii::t('InstallModule.yii',  'To use memcached set <a href="http://www.yiiframework.com/doc/api/CMemCache#useMemcached-detail">CMemCache::useMemcached</a> to <code>true</code>.') : ''),
            array(
                Yii::t('InstallModule.yii', 'APC extension'),
                false,
                extension_loaded("apc"),
                '<a href="http://www.yiiframework.com/doc/api/CApcCache">CApcCache</a>',
                ''),
            array(
                Yii::t('InstallModule.yii', 'Mcrypt extension'),
                false,
                extension_loaded("mcrypt"),
                '<a href="http://www.yiiframework.com/doc/api/CSecurityManager">CSecurityManager</a>',
                Yii::t('InstallModule.yii', 'This is required by encrypt and decrypt methods.')),
            array(
                Yii::t('InstallModule.yii', 'SOAP extension'),
                false,
                extension_loaded("soap"),
                '<a href="http://www.yiiframework.com/doc/api/CWebService">CWebService</a>, <a href="http://www.yiiframework.com/doc/api/CWebServiceAction">CWebServiceAction</a>',
                ''),
            array(
                Yii::t('InstallModule.yii', 'GD extension with<br />FreeType support<br />or ImageMagick<br />extension with<br />PNG support'),
                false,
                '' === $message=self::checkCaptchaSupport(),
                '<a href="http://www.yiiframework.com/doc/api/CCaptchaAction">CCaptchaAction</a>',
                $message),
            array(
                Yii::t('InstallModule.yii', 'Ctype extension'),
                false,
                extension_loaded("ctype"),
                '<a href="http://www.yiiframework.com/doc/api/CDateFormatter">CDateFormatter</a>, <a href="http://www.yiiframework.com/doc/api/CDateFormatter">CDateTimeParser</a>, <a href="http://www.yiiframework.com/doc/api/CTextHighlighter">CTextHighlighter</a>, <a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>',
                ''
            )
        );
        $result = 1;  // 1: all pass, 0: fail, -1: pass with warnings
        foreach ($requirements as $i => $requirement) {
            if ($requirement[1] && !$requirement[2]) {
                $result = 0;
            } else if ($result > 0 && !$requirement[1] && !$requirement[2]) {
                $result = -1;
            }
            if ($requirement[4] === '') {
                $requirements[$i][4] = '&nbsp;';
            }
        }
        $info[] = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '';
        $info[] = Yii::powered() . Yii::getVersion();
        $info[] = @strftime('%Y-%m-%d %H:%M', time());

        return array('result' => $result, 'requirements' => $requirements, 'info' => implode(' ', $info));
    }

    public static function checkServerVar()
    {
        $vars = array('HTTP_HOST', 'SERVER_NAME', 'SERVER_PORT', 'SCRIPT_NAME', 'SCRIPT_FILENAME', 'PHP_SELF', 'HTTP_ACCEPT', 'HTTP_USER_AGENT');
        $missing = array();
        foreach ($vars as $var) {
            if (!isset($_SERVER[$var])) {
                $missing[] = $var;
            }
        }
        if (!empty($missing)) {
            return Yii::t('InstallModule.yii', '$_SERVER does not have {vars}.', array('{vars}' => implode(', ', $missing)));
        }

        /*if (realpath($_SERVER["SCRIPT_FILENAME"]) !== realpath(__FILE__)) {
            return Yii::t('InstallModule.yii', '$_SERVER["SCRIPT_FILENAME"] must be the same as the entry script file path.');
        }*/

        if (!isset($_SERVER["REQUEST_URI"]) && isset($_SERVER["QUERY_STRING"])) {
            return Yii::t('InstallModule.yii', 'Either $_SERVER["REQUEST_URI"] or $_SERVER["QUERY_STRING"] must exist.');
        }

        if (!isset($_SERVER["PATH_INFO"]) && strpos($_SERVER["PHP_SELF"], $_SERVER["SCRIPT_NAME"]) !== 0) {
            return Yii::t('InstallModule.yii', 'Unable to determine URL path info. Please make sure $_SERVER["PATH_INFO"] (or $_SERVER["PHP_SELF"] and $_SERVER["SCRIPT_NAME"]) contains proper value.');
        }

        return '';
    }

    public static function checkCaptchaSupport()
    {
        if (extension_loaded('imagick')) {
            $imagick        = new Imagick();
            $imagickFormats = $imagick->queryFormats('PNG');
        }
        if (extension_loaded('gd')) {
            $gdInfo = gd_info();
        }
        if (isset($imagickFormats) && in_array('PNG', $imagickFormats)) {
            return '';
        } elseif (isset($gdInfo)) {
            if ($gdInfo['FreeType Support']) {
                return '';
            }
            return Yii::t('InstallModule.yii', 'GD installed,<br />FreeType support not installed');
        }
        return Yii::t('InstallModule.yii', 'GD or ImageMagick not installed');
    }

    public static function checkIsWritableDirectories($dirs = array('webroot.assets', 'application.config', 'application.runtime', 'application.modules', 'webroot.uploads'))
    {
        $result = array();
        foreach ($dirs as $dir) {
            $alias = Yii::getPathOfAlias($dir);
            $result[$alias] = is_writable($alias);
        }
        return $result;
    }

    public static function getPreferredLanguage()
    {
        $lang = 'en';
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && ($n = preg_match_all('/([\w\-]+)\s*(;\s*q\s*=\s*(\d*\.\d*))?/', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches)) > 0) {
            $languages = array();
            for ($i = 0; $i < $n; ++$i) {
                $languages[$matches[1][$i]] = empty($matches[3][$i]) ? 1.0 : floatval($matches[3][$i]);
            }
            arsort($languages);
            foreach ($languages as $language => $pref) {
                $lang = strtolower(str_replace('-', '_', $language));
                if (preg_match("/^en\_?/", $lang)) {
                    return 'en';
                } else {
                    break;
                }
            }
            return $lang;
        }
        return $lang;
    }

    /**
     * @param string $fileName
     * @param array $data
     * @return int file_put_contents
     */
    public static function parseConfig($fileName, $data)
    {
        $export = preg_replace('/[ ]{2}/', "    ", str_replace("\r", '', var_export($data, true)));
        $export = preg_replace("/\=\>[ \n]+array[ ]+\(/", '=> array(', $export);
        $export = preg_replace("/array\([\n][ ]{4}\)/", 'array()', $export);
        $export = str_replace('array (', 'array(', $export);
        return file_put_contents(
            Yii::getPathOfAlias('application.config') . DIRECTORY_SEPARATOR . $fileName . '.php',
            '<?php' . PHP_EOL . 'return ' . $export . ';' . PHP_EOL
        );
    }
}

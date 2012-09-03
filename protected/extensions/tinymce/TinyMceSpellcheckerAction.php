<?php
//http://www.tinymce.com/wiki.php/Plugin:spellchecker

class TinyMceSpellcheckerAction extends CAction
{
    public $settings = array(
        // General settings
        'general.engine' => 'GoogleSpell',

        //'general.engine' => 'PSpell',
        // PSpell settings
        //'PSpell.mode' => PSPELL_FAST,
        //'PSpell.spelling' => "",
        //'PSpell.jargon' => "",
        //'PSpell.encoding' => "",

        //'general.engine' => 'PSpellShell',
        // PSpellShell settings
        //'PSpellShell.mode' => PSPELL_FAST,
        //'PSpellShell.aspell' => '/usr/bin/aspell',
        //'PSpellShell.tmp' => '/tmp',

        //'general.engine' => 'http://some.other.site/some/url/rpc.php',


        // Windows PSpellShell settings
        //'PSpellShell.aspell' => '"c:\Program Files\Aspell\bin\aspell.exe"',
        //'PSpellShell.tmp' => 'c:/temp',
    );

    public function run()
    {
        require_once(dirname(__FILE__) . "/vendors/tinymce/spellchecker/classes/SpellChecker.php");
        $config = $this->settings;
        if (isset($config['general.engine']))
            require_once(dirname(__FILE__) . "/vendors/tinymce/spellchecker/classes/" . $config["general.engine"] . ".php");


        $raw = "";

        // Try param
        if (isset($_POST["json_data"]))
            $raw = $this->getRequestParam("json_data");

        // Try globals array
        if (!$raw && isset($_GLOBALS) && isset($_GLOBALS["HTTP_RAW_POST_DATA"]))
            $raw = $_GLOBALS["HTTP_RAW_POST_DATA"];

        // Try globals variable
        if (!$raw && isset($HTTP_RAW_POST_DATA))
            $raw = $HTTP_RAW_POST_DATA;

        // Try stream
        if (!$raw) {
            if (!function_exists('file_get_contents')) {
                $fp = fopen("php://input", "r");
                if ($fp) {
                    $raw = "";

                    while (!feof($fp))
                        $raw = fread($fp, 1024);

                    fclose($fp);
                }
            } else
                $raw = "" . file_get_contents("php://input");
        }

        // No input data
        if (!$raw)
            die('{"result":null,"id":null,"error":{"errstr":"Could not get raw post data.","errfile":"","errline":null,"errcontext":"","level":"FATAL"}}');

        // Passthrough request to remote server
        if (isset($config['general.remote_rpc_url'])) {
            $url = parse_url($config['general.remote_rpc_url']);

            // Setup request
            $req = "POST " . $url["path"] . " HTTP/1.0\r\n";
            $req .= "Connection: close\r\n";
            $req .= "Host: " . $url['host'] . "\r\n";
            $req .= "Content-Length: " . strlen($raw) . "\r\n";
            $req .= "\r\n" . $raw;

            if (!isset($url['port']) || !$url['port'])
                $url['port'] = 80;

            $errno = $errstr = "";

            $socket = fsockopen($url['host'], intval($url['port']), $errno, $errstr, 30);
            if ($socket) {
                // Send request headers
                fputs($socket, $req);

                // Read response headers and data
                $resp = "";
                while (!feof($socket))
                    $resp .= fgets($socket, 4096);

                fclose($socket);

                // Split response header/data
                $resp = explode("\r\n\r\n", $resp);
                echo $resp[1]; // Output body
            }

            die();
        }

        // Get JSON data
        $input = CJSON::decode($raw);

        // Execute RPC
        if (isset($config['general.engine'])) {
            $spellchecker = new $config['general.engine']($config);
            $result = call_user_func_array(array($spellchecker, $input['method']), $input['params']);
        } else
            die('{"result":null,"id":null,"error":{"errstr":"You must choose an spellchecker engine in the config.php file.","errfile":"","errline":null,"errcontext":"","level":"FATAL"}}');
        //var_dump($result);
        // Request and response id should always be the same
        $output = array(
            "id" => $input['id'],
            "result" => $result,
            "error" => null
        );

        // Return JSON encoded string
        echo CJSON::encode($output);
    }

    /**
     * Returns an request value by name without magic quoting.
     *
     * @param String $name Name of parameter to get.
     * @param bool|String $default_value Default value to return if value not found.
     * @return String request value by name without magic quoting or default value.
     */
    function getRequestParam($name, $default_value = false)
    {
        if (!isset($_REQUEST[$name]))
            return $default_value;

        if (is_array($_REQUEST[$name])) {
            $newarray = array();

            foreach ($_REQUEST[$name] as $name => $value)
                $newarray[$name] = $value;

            return $newarray;
        }

        return $_REQUEST[$name];
    }

}

<?php 

require_once dirname(__FILE__) . "blaze_utils.php"

define('BLAZE_VERSION', '0.0.1');

// @brief This object does the heavy lifting regarding any CLI specific processing
// that needs to be done.
// @link http://php.net/manual/en/features.commandline.php
class Blaze_CLI 
{
    public function __construct() {
        if (! self::is_cli()) {
            throw new Blaze_Exception("Must be running in PHP-CLI to execute this script.");
        }
    }

    public function execute($config) {
        $loader = new Blaze_Loader();
        $engine = null, $processor = null;

        if (isset($config["engine"])) {
            $engine = $loader->engine($config["engine"]);
        }
        else {

        }

        if ($config["help"] === true) {
            $processor = $loader->processor("help");
        }
        else if (isset($config["processor"])) {
            $processor = $loader->processor($config["processor"]);
        }
        else {

        }

        $engine->execute($processor);
    }

    // @brief Helper method which provides an easily mechanism for determining if
    // we are running in the CLI or via some web server.
    // @return boolean Returns true if script is executing on the CLI, otherwise
    // false.
    private static function is_cli() {
        if (!defined('STDIN') && self::is_cgi()) {
            if (getenv('TERM')) {
                return true;
            }

            return false;
        }

        return defined('STDIN');
    }

    private static function is_cgi() {
        if (substr(PHP_SAPI, 0, 3) == 'cgi') {
            return true;
        }
        
        return false;
    }

}

?>
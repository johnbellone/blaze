<?php
define('BLAZE_VERSION', '0.0.1');
! defined('BLAZE_PATH') AND define('BLAZE_PATH', dirname(__FILE__))

require_once "blaze_utils.php"
require_once "blaze_loader.php"
require_once "blaze_exception.php"

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

    public function execute($arguments) {
        if (!isset($arguments[0])) {
            throw new Blaze_Exception("Invaild argument count.");
        }

        $command = $arguments[0];
        $engine = null;

        if (isset($config["engine"])) {
            $engine = $config["engine"];
        }

        $loader = new Blaze_Loader($engine);
        $loader->execute($command, $arguments);
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
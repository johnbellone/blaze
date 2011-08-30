<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");
! defined('CODEIGNITER_PATH') AND define('CODEIGNITER_PATH', TOOLS_PATH . "/..");
! defined('PROCESSOR_PATH') AND define('PROCESSOR_PATH', dirname(__FILE__) . '/codeigniter');

require_once BLAZE_PATH . "blaze_engine.php";

class Engine_codeigniter extends Blaze_Engine
{
    public static function is_framework() {
        if (!file_exists(CODEIGNITER_PATH)) {
            return false;
        }

        return is_file(CODEIGNITER_PATH . "/system/core/CodeIgniter.php");
    }

    public function __construct() {
        $this->name = "codeigniter";
    }

    public function generate($arguments) {

    }
}

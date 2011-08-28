<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");
! defined('CODEIGNITER_PATH') AND define('CODEIGNITER_PATH', dirname(TOOLS_PATH . "../system"))
! defined('PROCESSOR_PATH') AND define('PROCESSOR_PATH', dirname(__FILE__) . '/codeigniter'))

require_once BLAZE_PATH . "blaze_engine.php"
require_once BLAZE_PATH . "blaze_exception.php"

class Engine_codeigniter extends Blaze_Engine
{
    public static function is_framework() {
        if (!file_exists(CODEIGNITER_PATH)) {
            return false;
        }

        return real_file(CODEIGNITER_PATH . "/core/CodeIgniter.php");
    }

    public function __construct() {

    }
}

?>
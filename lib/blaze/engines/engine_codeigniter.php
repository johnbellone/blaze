<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");
! defined('CODEIGNITER_PATH') AND define('CODEIGNITER_PATH', TOOLS_PATH . "/..");
! defined('PROCESSOR_PATH') AND define('PROCESSOR_PATH', dirname(__FILE__) . '/codeigniter');

require_once BLAZE_PATH . "blaze_engine.php";

/*
 * Engine for Blaze to support CodeIgniter framework.
 *
 * @package Blaze
 * @subpackage codeigniter
 * @author John Bellone <jb@thunkbrightly.com>
 */
class Engine_codeigniter extends Blaze_Engine
{
    private $shortcuts = array("g" => "generate");
    
    public static function is_framework()
    {
        return is_file(CODEIGNITER_PATH . "/system/core/CodeIgniter.php");
    }

    public function __construct()
    {
        $this->name = "codeigniter";
    }

    public function help()
    {
        
    }

    public function execute($method, $arguments)
    {
        if (array_key_exists($method, $this->shortcuts))
        {
            $method = $this->shortcuts[$method];
        }

        if (($processor = parent::load_class($method)) == false)
        {
            $this->help();
            return false;
        }

        return $processor->execute($arguments);
    }
}

<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");

require_once BLAZE_PATH . "blaze_processor.php";

/*
 * Generate processor for CodeIgniter engine.
 *
 * @package Blaze
 * @subpackage codeigniter
 * @author John Bellone
 */
class Codeigniter_generate extends Blaze_Processor
{
    protected function construct_method_string($tmpl_dir, $arguments)
    {
        $output = "";
        
        if (count($arguments) >= 0)
        {
            $method_tmpl = file_get_contents($tmpl_dir . "method.tmpl");                             
            $reg = "/^([a-zA-Z0-9])+/";
        
            while (($arg = array_shift($arguments)) !== null)
            {
                if (preg_match($reg, $arg))
                {
                    $name = strtolower($arg);
                    $output .= str_replace("%METHOD_NAME%", $name, $method_tmpl);
                }                
            }
        }

        return $output;
    }
    
    public function __construct()
    {

    }

    public function controller($arguments)
    {
        if (count($arguments) == 0)
        {
            // TODO: Some kind of nastygram.
            return false;
        }

        // Minimum required is just the class name to generate the file.
        $class_tolower = strtolower(array_shift($arguments));
        $class_ucfirst = ucfirst($class_tolower);
        
        // Load up the templates.
        $tmpl_dir = dirname(__FILE__) . "/templates/";
        $class_tmpl = file_get_contents($tmpl_dir . "controller.tmpl");

        // Parse array for methods and load their template.
        $method_output = $this->construct_method_string($tmpl_dir, $arguments);

        $inputs = array("%CLASS_UCFIRST%", "%METHOD_OUTPUT%", "%CLASS_TOLOWER%");
        $outputs = array($class_ucfirst, $method_output, $class_tolower);
        $output = str_replace($inputs, $outputs, $class_tmpl);

        $filename = $class_tolower . ".php";
        $output_path = CODEIGNITER_PATH . "/application/controllers/" . $filename;

        file_put_contents($output_path, $output);
        
        return true;
    } 
    
    public function help()
    {

    }
}
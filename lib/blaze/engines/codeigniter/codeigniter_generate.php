<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");

require_once BLAZE_PATH . "blaze_processor.php";
require_once BLAZE_PATH . "blaze_template.php";

/*
 * Generate processor for CodeIgniter engine.
 *
 * @package Blaze
 * @subpackage codeigniter
 * @author John Bellone <jb@thunkbrightly.com> 
 */
class Codeigniter_generate extends Blaze_Processor
{
	protected function construct_method_string($template, $arguments)
	{
		$output = "";
		
		if (count($arguments) >= 0)
		{
                
			$method_tmpl = $template->load("method.tmpl");
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

	public function model($arguments)
	{
		if (count($arguments) == 0)
		{
            $this->help();                    
			return false;
		}

		// Minimum required is just the class name to generate the file.
		$class_tolower = strtolower(array_shift($arguments));
		$class_ucfirst = ucfirst($class_tolower);
		$filename = CODEIGNITER_PATH . "/application/models/";
		
		$template = new Blaze_Template(dirname(__FILE__) . "/templates/");
		$model_tmpl = $template->load("model.tmpl");

		$inputs = array("%CLASS_UCFIRST%", "%CLASS_TOLOWER%");
		$outputs = array($class_ucfirst, $class_tolower);
		$filename .= $class_tolower . ".php";
		
		$template->save($filename, $model_tmpl, $inputs, $outputs);

		return true;
	}
	
	public function controller($arguments)
	{
		if (count($arguments) == 0)
		{
            $this->help();
			return false;
		}

		// Minimum required is just the class name to generate the file.
		$class_tolower = strtolower(array_shift($arguments));
		$class_ucfirst = ucfirst($class_tolower);
		$filename = CODEIGNITER_PATH . "/application/controllers/";
		
		$reg = "/^([a-z]+\/)+/";
		if (preg_match($reg, $class_tolower, $m))
		{
			$filename .= $m[0];
			@mkdir($filename, 0755);

			$reg = "/[a-z0-9_]+$/";
			preg_match($reg, $class_tolower, $m);
			$class_tolower = $m[0];
			$class_ucfirst = ucfirst($class_tolower);
		}
		
		// Load up the templates.
		$template = new Blaze_Template(dirname(__FILE__) . "/templates/");
		$class_tmpl = $template->load("controller.tmpl");

		// Parse array for methods and load their template.
		$method_output = $this->construct_method_string($template, $arguments);

		$inputs = array("%CLASS_UCFIRST%", "%METHOD_OUTPUT%", "%CLASS_TOLOWER%");
		$outputs = array($class_ucfirst, $method_output, $class_tolower);
		$filename .= $class_tolower . ".php";

		$template->save($filename, $class_tmpl, $inputs, $outputs);

		return true;
	} 

	public function view($arguments)
	{
		if (count($arguments) === 0)
		{
				$this->help();		  
				return false;
		}
	}
	
	public function help()
	{
		echo <<<HELP
Usage: php tools/blaze generate [ARGS]

The following arguments will generate CodeIgniter classes:
        controller      Generates a stub controller
        model           Generates a stub model
        view            Generates a stub view

HELP;
		  }
}
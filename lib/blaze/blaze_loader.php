<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");

/*
 * Engine class loader.
 *
 * Object handles class loading and framework enumeration.
 *
 * @package Blaze
 * @author John Bellone <jb@thunkbrightly.com>
 */
class Blaze_Loader 
{
    protected $_classes = array();
	protected $adapter = null;

	protected function load_engine($class)
    {
        if (! array_key_exists($class, $this->_classes))
        {
            if (count($this->_classes) > 0)
            {
                return false;
            }
        
            $engine_dir = dirname(__FILE__) . "/engines";
            $reg = "/^engine_([a-zA-Z0-9]+).php/";
            
            if (is_dir($engine_dir) && ($dh = opendir($engine_dir)))
            {
                while (($file = readdir($dh)) !== false)
                {
                    if (preg_match($reg, $file, $matches) > 0)
                    {
                        include_once($engine_dir . '/' . $file);

                        $klass = "Engine_" . $matches[1];
                        $this->_classes[$klass] = new $klass();
                    }
                }
            }
        }
        
        if (! array_key_exists($class, $this->_classes))
        {
            return false;
        }
        
        return $this->_classes[$class];
	}

	public function __construct($class)
    {
        if (($this->adapter = $this->load_engine($class)) === false)
        {
            foreach ($this->_classes as $engine)
            {
                if ($engine->is_framework())
                {
                    $this->adapter = $engine;
                    break;
                }
            }
        }

        if (!isset($this->adapter))
        {
            throw new Exception("Please make sure that Blaze is installed correctly.");
        }
	}

	public function execute($method, $arguments, $config)
    {
        if (!isset($method) || array_key_exists("help", $config) === true)
        {
            $this->help();
            return false;
        }

        if (method_exists($this->adapter, $method))
        {
            return $this->adapter->{$method}($arguments);
        }

        // Mainly for the aliases
        return $this->adapter->execute($method, $arguments);
	}

    public function help()
    {
        if (method_exists($this->adapter, "help") == true)
        {
            $this->adapter->help();
        }
        else
        {
                
        }
    }
}

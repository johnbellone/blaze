<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");

class Blaze_Loader 
{
    protected $_eg_classes = array();
	protected $adapter = null;

	protected function load_engine($class) {
        if (! array_key_exists($class, $this->_eg_classes)) {
            if (count($this->_eg_classes) > 0) {
                return false;
            }
        
            $engine_dir = dirname(__FILE__) . "/engines";
            $reg = "/engine_([a-zA-Z0-9]+).php/";
            
            if (is_dir($engine_dir) && ($dh = opendir($engine_dir))) {
                while (($file = readdir($dh)) !== false) {
                    if (preg_match($reg, $file, $matches) > 0) {
                        include_once($engine_dir . '/' . $file);

                        $klass = "Engine_" . $matches[1];
                        $this->_eg_classes[$klass] = new $klass();
                    }
                }
            }
        }
        
        if (! array_key_exists($class, $this->_eg_classes)) {
            return false;
        }
        
        return $this->_eg_classes[$class];
	}

	public function __construct($class) {
        if (($this->adapter = $this->load_engine($class)) === false) {
            foreach ($this->_eg_classes as $engine) {
                if ($engine->is_framework()) {
                    $this->adapter = $engine;
                    break;
                }
            }
        }

        if (!isset($this->adapter)) {
            throw new Exception("Unable to determine engine");
        }
	}

	public function execute($method, $arguments) {
        if (!method_exists($this->adapter, $method)) {
            return false;
        }
        
		return $this->adapter->{$method}($arguments);
	}
}

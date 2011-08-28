<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");

require_once "blaze_exception.php"

class Blaze_Loader 
{
    protected $_classes = array();
    protected $adapter = null;

    protected function load_engine($class) {
        // First check the cached (already loaded) files.
        if (isset($this->_classes[$class])) {
            return $this->_classes[$class];
        }

        if (count($this->_classes) > 0) {
            throw new Blaze_Exception("Engine doesn't exist.");
        }

        // TODO: Load all of the classes here.
    }

    public function __construct($class) {
        $this->adapter = $this->load_engine($class);

        if (!isset($this->adapter)) {
            throw new Blaze_Exception("");
        }
    }

    public function execute($arguments, $class = null) {
        if (!isset($this->adapter)) {
            throw new Blaze_Exception("");
        }

        if (!method_exists($this->adapter, $method)) {
            throw new Blaze_Exception("");
        }

        return $this->adapter->{$method}($arguments);
    }
}

?>
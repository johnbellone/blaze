<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");

class Blaze_Engine
{
    protected $name = "dummy";

    protected function load_processor($class)
    {
        $class = strtolower($class);
        $processor_dir = dirname(__FILE__) . '/' . $this->name;
        $filename = $processor_dir . '/' . $this->name . '_' . $class . '.php';

        if (is_file($filename))
        {
            include_once($filename);

            $klass = ucfirst($class) . "_" . $class;
            return new $klass();
        }

        return false;
    }
    
    public function __construct()
    {
        
    }

    public function name()
    {
        return $this->name;
    }
}

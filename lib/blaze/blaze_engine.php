<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");

/*
 * Base engine object.
 * 
 * Handles class loading for engine processors.
 *
 * @package Blaze
 * @author John Bellone <jb@thunkbrightly.com>
 */
class Blaze_Engine
{
    protected $name = "dummy";

    protected function load_class($class)
    {
        $class = strtolower($class);
        $processor_dir = dirname(__FILE__) . '/engines/' . $this->name;
        $filename = $processor_dir . '/' . $this->name . '_' . $class . '.php';

        if (is_file($filename))
        {
            include_once($filename);

            $klass = ucfirst($this->name) . "_" . $class;

            // Make sure that we actually loaded it correctly.
            if (class_exists($klass))
            {
                return new $klass();
            }
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

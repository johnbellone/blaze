<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");

/*
 * Template loader.
 *
 * @package Blaze
 * @author John Bellone <jb@thunkbrightly.com>
 */
class Blaze_Template
{
    protected $_directories = array();
    protected $_input = null;
        
    public function __construct($include_dir)
    {
        if (is_array($include_dir))
        {
            foreach ($include_dir as $dir)
            {
                $this->include_directory($dir);
            }
        }
        else
        {
            $this->include_directory($include_dir);
        }
    }

    public function include_directory($dir)
    {
        if (is_dir($dir))
        {
            $this->_directories[] = $dir;
            return true;
        }
                
        return false;    
    }

    public function load($template)
    {
        $filename = "";
        
        foreach ($this->_directories as $dir)
        {
            $fname = $dir . $template;

            if (is_file($fname))
            {
                $filename = $fname;
                break;
            }
        }

        if ($fname === "")
        {
            return false;
        }

        return file_get_contents($fname);
    }

    public function replace($buffer, $inputs, $outputs)
    {
        if (! isset($buffer))
        {
            return false;
        }

        return str_replace($inputs, $outputs, $buffer);
    }
    
    public function save($filename, $input, $tags_array = array(), $replace_array = array())
    {
        if (! isset($input) || ! isset($filename))
        {
            return false;
        }

        $output = $input;
        
        if (count($tags_array) > 0 && count($replace_array) > 0)
        {
            if (($output = $this->replace($input, $tags_array, $replace_array)) === false)
            {
                return false;
            }
        }

        if (is_file($filename))
        {
            return false;
        }
        
        file_put_contents($filename, $output);
        return true;
    }
}

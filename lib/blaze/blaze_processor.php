<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");

/*
 * Object representing a framework command processor.
 *
 * @package Blaze
 * @author John Bellone <jb@thunkbrightly.com>
 */
class Blaze_Processor
{
    public function execute($arguments)
    {
        if (count($arguments) > 0)
        {
            $method = array_shift($arguments);
            
            if (method_exists($this, $method))
            {
                return $this->{$method}($arguments);
            }
        }

        // Execute the help on the actual extended object; if a method
        // does not exist then we will execute on this base object. But
        // there should always be a help method.
        $this->help();
        return false;
    }
    
    public function help()
    {
        // TODO: Something meaningful would be amazing here.
        echo "Sorry, there's nothing to help you with.";
    }
}

<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");

/*
 * Object representing a framework command processor.
 *
 * @package Blaze
 * @author John Bellone
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

        return false;
    }
}
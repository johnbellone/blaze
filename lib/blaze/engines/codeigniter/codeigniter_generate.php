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
        $klass = array_shift($arguments);
    } 
    
    public function help()
    {

    }
}
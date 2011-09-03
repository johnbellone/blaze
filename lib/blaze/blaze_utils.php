<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");

/*
 * Utility object.
 *
 * @package Blaze
 * @author John Bellone
 */
class Blaze_Utils
{
    // @link http://pwfisher.com/nucleus/index.php?itemid=45
    public static function parse_arguments($argv) 
    {
        array_shift($argv); 
        $output = array();

        foreach ($argv as $arg)
        {
            if (substr($arg, 0, 2) === '--')
            {
                $eq = strpos($arg, '=');
                
                if ($eq !== false)
                {
                    $output[substr($arg, 2, $eq-2)] = substr($arg, $eq+1);
                }
                else
                {
                    $k = substr($arg, 2);

                    if (!isset($output[$k]))
                    {
                        $output[$k] = true;
                    }
                }
            }
            else if (substr($arg, 0, 1) === '-')
            {
                if (substr($arg, 2, 1) === '=')
                {
                    $output[substr($arg, 1, 1)] = substr($arg, 3); 
                }
                else
                {
                    foreach (str_split(substr($arg, 1)) as $k)
                    {
                        if (!isset($output[$k]))
                        {
                            $output[$k] = true;
                        }
                    }
                }
            }
            else
            {
                $output[] = $arg;
            }
        }

        return $output;
    }
}

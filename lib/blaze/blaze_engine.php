<?php if (! defined('BLAZE_PATH')) exit("No direct script access allowed");

class Blaze_Engine
{
    protected $name = "dummy";
    
    public function __construct() {

    }

    public function name() {
        return $this->name;
    }
}

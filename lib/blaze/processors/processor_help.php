<?php

class Processor_help 
{
    private $engine = null;

    public function __construct($the_engine) {
        $engine = $the_engine;
    }

    public function execute() {
        $engine->help();
    }
}
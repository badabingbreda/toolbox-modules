<?php

namespace ToolboxModules;

use ToolboxModules\Frontend;
use ToolboxModules\Integration\BeaverBuilder;
class Init {

    public function __construct() {
        add_action( 'plugins_loaded' , __CLASS__ . '::init_frontend' );

        new BeaverBuilder();
    }
    
    public static function init_frontend() {
        new Frontend();
    }
}
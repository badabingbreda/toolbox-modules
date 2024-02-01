<?php

namespace ToolboxModules;

use ToolboxModules\Frontend;
use ToolboxModules\Integration\BeaverBuilder;
use ToolboxModules\Integration\Toolbox;
class Init {

    public function __construct() {
        add_action( 'plugins_loaded' , __CLASS__ . '::init_frontend' );

        new BeaverBuilder();
        new Toolbox();
    }
    
    public static function init_frontend() {
        new Frontend();
    }
}
<?php
namespace ToolboxModules\Integration;

use ToolboxModules\Helpers\File;

class BeaverBuilder {

    public function __construct() {

        add_action( 'init' , __CLASS__ . '::load_modules' );

    }

    /**
     * load_modules
     *
     * @return void
     */
    public static function load_modules() {
        /**
         * Check if class exists first
         */
        if ( !class_exists( 'FLBuilder' )) return;

        /**
         * Load the modules
         */

        File::requireFilesInPath(TOOLBOXMODULES_DIR . 'modules');
    }

}
<?php
namespace ToolboxModules\Helpers;

class File {

    public static function requireFilesInPath($path) {

        // get a list of directories
        $directories = glob($path . '/*' , GLOB_ONLYDIR);

        // loop over the directories
        foreach ($directories as $directory) {

            // check if there's a file first before trying to load it
            if( file_exists( $directory . '/' . basename($directory) . '.php' ) ) {
                require_once $directory . '/' . basename($directory) . '.php';
            }
        }

        return true;
    }

}
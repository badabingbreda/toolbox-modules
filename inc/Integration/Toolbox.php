<?php

namespace ToolboxModules\Integration;

class Toolbox {

    public function __construct() {
        add_filter( 'toolbox_twig_views_locations'      , __CLASS__ . '::add_twigs_dir' , 25 ,1  );
        add_filter( 'timber/loader/loader'              , __CLASS__ . '::add_twig_namespace' );

        add_filter( 'toolbox/htmx_dirs'                 , __CLASS__ . '::htmx_twigs' , 10 , 1 ) ;
        
    }
    
    /**
     * add_twigs_dir
     * 
     * Add our plugin's twig-templates directory to the paths to look in for twig templates
     *
     * @param  mixed $views
     * @return void
     */
    public static function add_twigs_dir( $views ) {

        return array_merge( $views, array(
                    TOOLBOXMODULES_DIR . 'modules',
                )
            );
    }   
    
    /**
     * Add a namespace to the loader so that we can load templates
     * that are specific to our plugin
     */
    public static function add_twig_namespace( $loader ) {

        $loader->addPath( TOOLBOXMODULES_DIR . 'modules' , 'toolboxmodules' );

        return $loader;
    }


    public static function htmx_twigs( $directories ) {

        return array_merge( $directories , [ TOOLBOXMODULES_DIR . 'modules' ] );
    }    

}
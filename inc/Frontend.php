<?php
namespace ToolboxModules;

use Toolbox\TimberProxy;

class Frontend extends \Timber {


    public function __construct() {

        // add toolbox filter(s)
        add_filter( 'timber/twig'                       , __CLASS__ . '::global_vars' );        

    }

    public static function beaverbuilderFrontend( $module_filename , $twigfile  , $settings , $id , $module ) {
        
        // set twig template filename here
        $string = file_get_contents( dirname( $module_filename ). $twigfile );

        // notice we use root Timber here
        $data = TimberProxy::context();

        $data[ 'settings' ] = $settings;
        $data[ 'id' ] = $id;
        $data[ 'module' ] = $module;

        /**
         * Extend the context with data
         * pass in the settings variable for the filter
         */
        $data = apply_filters( 'toolbox/timber_context', $data , $settings , $id , $module ); 

        /**
         * Add filter data based on the module-Attribute ID
         */
        if ( $settings->id ) $data = apply_filters( "toolbox/timber_context/{$settings->id}", $data , $settings , $id , $module );

        /**
         * Add filter data based on the module-ID
         */
        $data = apply_filters( "toolbox/timber_context/{$id}", $data , $settings , $id , $module );


        // probeer het zonder een fout te genereren.
        try {
            \Timber::render_string( $string , $data );
        } catch ( \Exception $error) {
            if ( apply_filters( 'toolbox/twig_error_debug' , false ) ) echo '[ error handling twig template ] ' . $error->getMessage();
        } catch ( \ParseError $error ) {
              echo 'ParseError: ' . $error->getMessage();
            return;
        } catch ( \Error $error ) {
            echo 'Error: ' . $error->getMessage();
            return;
        }

        wp_reset_postdata();
    }

    public static function global_vars( $twig ) {

        // For this, make sure Beaver Builder is used by checking the class
        if ( !class_exists('FLBuilderModel')) return $twig;

		// get Timber version
		if (version_compare(\Timber::$version, '2.0.0', '>=')) {
            /**
             * Add functions for the frontend.css.twig
             * @example  
             */
            $twig->addFunction(new \Twig\TwigFunction( 'css_rule', __CLASS__ . '::css_rule'  ) );
            $twig->addFunction(new \Twig\TwigFunction( 'css_responsive_rule', __CLASS__ . '::css_responsive_rule'  ) );
            $twig->addFunction(new \Twig\TwigFunction( 'css_dimension_field_rule', __CLASS__ . '::css_dimension_field_rule'  ) );
            $twig->addFunction(new \Twig\TwigFunction( 'css_compound_field_rule', __CLASS__ . '::css_compound_field_rule'  ) );
            $twig->addFunction(new \Twig\TwigFunction( 'css_border_field_rule', __CLASS__ . '::css_border_field_rule'  ) );
            $twig->addFunction(new \Twig\TwigFunction( 'css_typography_field_rule', __CLASS__ . '::css_typoghraphy_field_rule'  ) );
    
            $twig->addFunction(new \Twig\TwigFunction( 'array_to_object' , __CLASS__ . '::array_to_object' ) );
    
            $twig->addFunction(new \Twig\TwigFunction( 'hex_or_rgb', __CLASS__ . '::hex_or_rgb'  ) );

        } else {

            /**
             * Add functions for the frontend.css.twig
             * @example  
             */
            $twig->addFunction(new \Timber\Twig_Function( 'css_rule', __CLASS__ . '::css_rule'  ) );
            $twig->addFunction(new \Timber\Twig_Function( 'css_responsive_rule', __CLASS__ . '::css_responsive_rule'  ) );
            $twig->addFunction(new \Timber\Twig_Function( 'css_dimension_field_rule', __CLASS__ . '::css_dimension_field_rule'  ) );
            $twig->addFunction(new \Timber\Twig_Function( 'css_compound_field_rule', __CLASS__ . '::css_compound_field_rule'  ) );
            $twig->addFunction(new \Timber\Twig_Function( 'css_border_field_rule', __CLASS__ . '::css_border_field_rule'  ) );
            $twig->addFunction(new \Timber\Twig_Function( 'css_typography_field_rule', __CLASS__ . '::css_typoghraphy_field_rule'  ) );
    
            $twig->addFunction(new \Timber\Twig_Function( 'array_to_object' , __CLASS__ . '::array_to_object' ) );
    
            $twig->addFunction(new \Timber\Twig_Function( 'hex_or_rgb', __CLASS__ . '::hex_or_rgb'  ) );
        }

        // add builder global_settings
        $twig->addGlobal( 'global_settings', \FLBuilderModel::get_global_settings() );

        return $twig;

    }

    public static function css_rule( $options ) {
        
        \FLBuilderCSS::rule( $options );
        return '';

    }    

    /**
     * css_responsive_rule
     * 
     * 'settings'          => null,
     * 'setting_name'      => '',
     * 'setting_base_name' => '',
     * 'selector'          => '',
     * 'prop'              => '',
     * 'props'             => array(),
     * 'unit'              => '',
     * 'enabled'           => true,
     * 'ignore'            => array(),
     *
     * @param  mixed $options
     * @return void
     */
    public static function css_responsive_rule( $options ) {
        
        \FLBuilderCSS::responsive_rule( $options );
        return '';

    }

    /**
     * css_dimension_field_rule
     *
     * 
     * 		'settings'     => null,
	 *		'setting_name' => '',
	 *		'selector'     => '',
	 *		'props'        => array(),
	 *		'unit'         => '',

     * @param  mixed $options
     * @return void
     */
    public static function css_dimension_field_rule( $options ) {
        
        \FLBuilderCSS::dimension_field_rule( $options );
        return '';

    }


    /**
     * css_compound_field_rule
     *
     *		'type'         => '',
	 *		'selector'     => '',
	 *		'settings'     => null,
	 *		'setting_name' => '',
     * 
     * @param  mixed $options
     * @return void
     */
    public static function css_compound_field_rule( $options ) {
        
        \FLBuilderCSS::compound_field_rule( $options );
        return '';

    }


    /**
     * css_border_field_rule
     * 
     * @uses    css_compound_field_rule
     *
     * @param  mixed $options
     * @return void
     */
    public static function css_border_field_rule( $options ) {
        
        \FLBuilderCSS::border_field_rule( $options );
        return '';

    }
    
    /**
     * css_typography_field_rule
     * 
     * @uses    css_compound_field_rule
     *
     * @param  mixed $options
     * @return void
     */
    public static function css_typography_field_rule( $options ) {
        
        \FLBuilderCSS::typography_field_rule( $options );
        return '';

    }   
        
    /**
     * hex_or_rgb
     *
     * @param  mixed $value
     * @return void
     */
    public static function hex_or_rgb( $value ) {
        return \FLBuilderColor::hex_or_rgb( $value );        
    }
    
    /**
     * array_to_object
     * 
     * array comes in, object comes out
     * (can be) used for css_responsive_rules, to get to __node__ settings, which are returned as an array
     *
     * @param  mixed $array
     * @return void
     */
    public static function array_to_object( $array ) {
        $object = json_decode(json_encode($array, JSON_FORCE_OBJECT));
        return $object;
    }    

}
<?php
namespace ToolboxModules;

use Toolbox\TimberProxy;


class Frontend extends \Timber {


    public function __construct() {

        // add toolbox filter(s)
        add_filter( 'timber/twig'                       , __CLASS__ . '::global_vars' ); 
        add_filter( 'toolbox/timber_context'            , __CLASS__ . '::timber_current_post' );
        add_filter( 'toolbox/timber_context'            , __CLASS__ . '::timber_main_query_vars' );

    }

    /**
     * wpdocs_get_paginated_links
     *
     * @param  mixed $query
     * @return void
     * @link https://developer.wordpress.org/reference/functions/paginate_links/#comment-3862
     */
    public static function get_paginated_links( $query ) {
        // When we're on page 1, 'paged' is 0, but we're counting from 1,
        // so we're using max() to get 1 instead of 0
        $currentPage = max( 1, get_query_var( 'paged', 1 ) );
    
        // This creates an array with all available page numbers, if there
        // is only *one* page, max_num_pages will return 0, so here we also
        // use the max() function to make sure we'll always get 1
        $pages = range( 1, max( 1, $query->max_num_pages ) );
    
        // Now, map over $pages and return the page number, the url to that
        // page and a boolean indicating whether that number is the current page
        $_pages = array_map( function( $page ) use ( $currentPage ) {
            return array(
                "is_current" => $page == $currentPage,
                "page" => (int) $page,
                "url" => get_pagenum_link( $page )
            );
        }, $pages );

        return [ 
            'total' => max( 1, $query->max_num_pages ),
            'current' => $currentPage,
            'pages' => $_pages,
        ];
    }  
    
    public static function timber_current_post( $data ) {

        if( is_singular() ){
            // current post
            $data['post'] = new \Timber\Post();
        } else {
            $data['post'] = false;
        }

        return $data;
    }

    public static function timber_main_query_vars( $data ) {

        global $wp_query;

        // get the wp_query->query_vars
        $args = $wp_query->query_vars;

        $data[ 'query' ][ 'vars' ] = $args;

        return $data;
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
             * make sure to check if the functions aren't defined already
             * @example  
             */
            if ( $twig->getFunction('css_rule') === false ) {
                $twig->addFunction(new \Twig\TwigFunction( 'css_rule', __CLASS__ . '::css_rule'  ) );
            }
            if ( $twig->getFunction('css_responsive_rule') === false ) {
                $twig->addFunction(new \Twig\TwigFunction( 'css_responsive_rule', __CLASS__ . '::css_responsive_rule'  ) );
            }
            if ( $twig->getFunction('css_dimension_field_rule') === false ) {
                $twig->addFunction(new \Twig\TwigFunction( 'css_dimension_field_rule', __CLASS__ . '::css_dimension_field_rule'  ) );
            }
            if ( $twig->getFunction('css_compound_field_rule') === false ) {
                $twig->addFunction(new \Twig\TwigFunction( 'css_compound_field_rule', __CLASS__ . '::css_compound_field_rule'  ) );
            }
            if ( $twig->getFunction('css_border_field_rule') === false ) {
                $twig->addFunction(new \Twig\TwigFunction( 'css_border_field_rule', __CLASS__ . '::css_border_field_rule'  ) );
            }
            if ( $twig->getFunction('css_typography_field_rule') === false ) {
                $twig->addFunction(new \Twig\TwigFunction( 'css_typography_field_rule', __CLASS__ . '::css_typoghraphy_field_rule'  ) );
            }
            if ( $twig->getFunction('array_to_object') === false ) {
                $twig->addFunction(new \Twig\TwigFunction( 'array_to_object' , __CLASS__ . '::array_to_object' ) );
            }
            if ( $twig->getFunction('hex_or_rgb') === false ) {
                $twig->addFunction(new \Twig\TwigFunction( 'hex_or_rgb', __CLASS__ . '::hex_or_rgb'  ) );
            }

        } else {

            /**
             * Add functions for the frontend.css.twig
             * make sure to check if the functions aren't defined already
             * @example  
             */
            if ( $twig->getFunction('css_rule') === false ) {
                $twig->addFunction(new \Timber\Twig_Function( 'css_rule', __CLASS__ . '::css_rule'  ) );
            }
            if ( $twig->getFunction('css_responsive_rule') === false ) {
                $twig->addFunction(new \Timber\Twig_Function( 'css_responsive_rule', __CLASS__ . '::css_responsive_rule'  ) );
            }
            if ( $twig->getFunction('css_dimension_field_rule') === false ) {
                $twig->addFunction(new \Timber\Twig_Function( 'css_dimension_field_rule', __CLASS__ . '::css_dimension_field_rule'  ) );
            }
            if ( $twig->getFunction('css_compound_field_rule') === false ) {
                $twig->addFunction(new \Timber\Twig_Function( 'css_compound_field_rule', __CLASS__ . '::css_compound_field_rule'  ) );
            }
            if ( $twig->getFunction('css_border_field_rule') === false ) {
                $twig->addFunction(new \Timber\Twig_Function( 'css_border_field_rule', __CLASS__ . '::css_border_field_rule'  ) );
            }
            if ( $twig->getFunction('css_typography_field_rule') === false ) {
                $twig->addFunction(new \Timber\Twig_Function( 'css_typography_field_rule', __CLASS__ . '::css_typoghraphy_field_rule'  ) );
            }
            if ( $twig->getFunction('array_to_object') === false ) {
                $twig->addFunction(new \Timber\Twig_Function( 'array_to_object' , __CLASS__ . '::array_to_object' ) );
            }
            if ( $twig->getFunction('hex_or_rgb') === false ) {
                $twig->addFunction(new \Timber\Twig_Function( 'hex_or_rgb', __CLASS__ . '::hex_or_rgb'  ) );
            }
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
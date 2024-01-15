<?php
/**
 * Toolbox Modules
 *
 * @package     toolbox-modules
 * @author      Badabingbreda
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Toolbox Modules
 * Plugin URI:  https://www.badabing.nl
 * Description: Toolbox Modules Demo
 * Version:     1.0.0
 * Author:      Badabingbreda
 * Author URI:  https://www.badabing.nl
 * Text Domain: toolbox-modules
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

 
 use ToolboxModules\Autoloader;
 use ToolboxModules\Init;
 
 if ( defined( 'ABSPATH' ) && ! defined( 'TOOLBOXMODULES_VERION' ) ) {
  register_activation_hook( __FILE__, 'TOOLBOXMODULES_check_php_version' );
 
  /**
   * Display notice for old PHP version.
   */
  function TOOLBOXMODULES_check_php_version() {
      if ( version_compare( phpversion(), '5.3', '<' ) ) {
         die( esc_html__( 'Toolbox Modules requires PHP version 5.3+. Please contact your host to upgrade.', 'mortgagebroker-calculator' ) );
     }
  }
 
   define( 'TOOLBOXMODULES_VERSION'   , '1.0.0' );
   define( 'TOOLBOXMODULES_DIR'     , plugin_dir_path( __FILE__ ) );
   define( 'TOOLBOXMODULES_FILE'    , __FILE__ );
   define( 'TOOLBOXMODULES_URL'     , plugins_url( '/', __FILE__ ) );
 
   define( 'CHECK_TOOLBOXMODULES_PLUGIN_FILE', __FILE__ );
 
 }
 
 if ( ! class_exists( 'ToolboxModules\Init' ) ) {
 
  /**
   * The file where the Autoloader class is defined.
   */
   require_once 'inc/Autoloader.php';
   spl_autoload_register( array( new Autoloader(), 'autoload' ) );
 
  $toolbox_modules = new Init();
 
 }
 
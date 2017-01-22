<?php
/**
Plugin Name: Twoot ToolKit
Plugin URI: http://themewoot.com
Description: Twoot ToolKit is the plugin for ThemeWoot Team's items. It only supports ThemeWoot Team's wordpress theme.
Version: 1.1.2
Author: ThemeWoot
Author URI: http://themeforest.net/user/ThemeWoot

@package WordPress
@subpackage ThemeWoot Theme
@author ThemeWoot Team 

This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
that is bundled with this package in the file LICENSE.txt.
It is also available through the world-wide-web at this URL:
http://www.gnu.org/licenses/gpl-3.0.txt
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if( ! class_exists( 'Twoot_ToolKit') ) {
/**
 * Main ToolKit Class
 *
 * Contains the main functions for Theme ToolKit, stores variables, and handles error messages
 *
 * @class Twoot_ToolKit
 * @version	1.0
 * @since 1.0
 * @package ThemeWoot
 * @author ThemeWoot Team 
 */
class Twoot_ToolKit {

	/**
	 * Version.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	 public $version = '1.1.4';


	 /**
	 * Name.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	 public $name = 'Twoot ToolKit';


	 /**
	 * Slug.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	 public $slug = 'twoot_toolkit';


	 /**
	 * Option Key.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	 public $opt_key = '_twoot_toolkit_opt';


	 /**
	* Constructor.
	*
	* @since   1.0.0
	*/
	public function __construct() {

		// Define Version
		define( 'TWOOT_TOOLKIT_VERSION', $this->version );

		// Define Name
		define( 'TWOOT_TOOLKIT_NAME', $this->name );

		// Define Slug
		define( 'TWOOT_TOOLKIT_SLUG', $this->slug );

		// Define Options
		define( 'TWOOT_TOOLKIT_OPTIONS', $this->opt_key );

		// Plugin Directory Path
		define( 'TWOOT_TOOLKIT_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

		// Plugin Directory URL
		define( 'TWOOT_TOOLKIT_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

		// Current Theme Path
		define( 'TWOOT_CURRENT_THEME_PATH', get_template_directory() );

		// Current Theme Path
		define( 'TWOOT_CURRENT_THEME_URL', get_template_directory_uri() );

		// Languages
		add_action( 'plugins_loaded', array( $this, 'languages') );

		// Update
		add_action( 'admin_init', array( $this, 'updated') );

		// Installation
		register_activation_hook( __FILE__, array( $this, 'activate' ) );

		// De Installation
		register_deactivation_hook( __FILE__, array( $this, 'deactivate') );

		// Includes
		$this->includes();

	}



	/**
	* Load plugin textdomain
	*
	* @since   1.0.0
	*/
	public function languages() {
		load_plugin_textdomain( 'Twoot_Toolkit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}



	/**
	* Activate the plugin
	*
	* @since   1.0.0
	*/
	public static function activate() {
		$twoot_toolkit_opts = array(
			'twitter_username' => '',
			'twitter_ck' => '',
			'twitter_cs' => '',
			'twitter_at' => '',
			'twitter_ats' => '',
			'flickr_id' => '',
			'dribbble_username' =>''
		);

		update_option( TWOOT_TOOLKIT_OPTIONS, $twoot_toolkit_opts );
		update_option( '_twoot_toolkit_version', TWOOT_TOOLKIT_VERSION );
	}



	/**
	* Updated
	*
	* @since   1.0.0
	*/
	public function updated() {
		$plugin_check = get_option( '_twoot_toolkit_version' );
		$is_checked  =  version_compare( TWOOT_TOOLKIT_VERSION, $plugin_check, '>' );

		if( $is_checked ) {
			update_option( '_twoot_toolkit_version', TWOOT_TOOLKIT_VERSION );
		}
	}



	/**
	* Deactivate the plugin
	*
	* @since   1.0.0
	*/
	 public static function deactivate() {
		 delete_option( '_twoot_toolkit_version' );
		 delete_option( '_twoot_toolkit_opt' );
	 }



	/**
	* Includes
	*
	* @since   1.0.0
	*/
	public function includes() {
		if( is_admin() ) {
			include_once( TWOOT_TOOLKIT_PATH . '/twoot-toolkit-page.php' );
		}
		include_once( TWOOT_TOOLKIT_PATH . '/classes/class-dribbble-handler.php' );
		include_once( TWOOT_TOOLKIT_PATH . '/classes/class-flickr-handler.php' );
		include_once( TWOOT_TOOLKIT_PATH . '/classes/class-twitter-handler.php' );
		include_once( TWOOT_TOOLKIT_PATH . '/post-types/post-types.php' );
		include_once( TWOOT_TOOLKIT_PATH . '/widgets/widgets.php' );
	}

}

/**
 * Init Toolkit
 */
$GLOBALS['twoot_theme_toolkit'] = new Twoot_ToolKit();
}


if( ! class_exists( 'Twoot_ToolKit_Support') ) {
/**
 * Main ToolKit Class
 *
 * Contains the main functions for Theme ToolKit, stores variables, and handles error messages
 *
 * @class Twoot_ToolKit
 * @version	1.0
 * @since 1.0
 * @package ThemeWoot
 * @author ThemeWoot Team 
 */
class Twoot_ToolKit_Support {

	/*
	 * Custom Post Type
	*/
	function post_type($args) {
		$types = new Twoot_Post_Types();
		$types->init($args);
	}


	/*
	 * Shortcodes
	*/
	function shortcode($args) {
		include_once( TWOOT_TOOLKIT_PATH . '/zilla-shortcodes/shortcodes.php' );
		$shortcodes = new Twoot_Shortcodes();
		$shortcodes->init($args);
	}


	/*
	 * Widgets
	*/
	function widget($args) {
		$widgets = new Twoot_Widgets();
		$widgets->init($args);
	}


	/*
	 * JS Composer
	*/
	function js_composer() {
		include_once( TWOOT_TOOLKIT_PATH . '/js_composer/js_composer.php' );
		require_once( TWOOT_CURRENT_THEME_PATH . '/theme/js-composer/map.php' );
		require_once( TWOOT_CURRENT_THEME_PATH . '/theme/js-composer/class-vc-base.php' );
		if(!is_admin()) {
			require_once( TWOOT_CURRENT_THEME_PATH . '/theme/js-composer/js-composer.php' );
		}
	}
}



/**
 * Init Toolkit Support
 */
function twoot_toolkit_support($function){
	global $_Twoot_ToolKit_Support;
	if($_Twoot_ToolKit_Support==null){
		$_Twoot_ToolKit_Support = new Twoot_ToolKit_Support();
	}
	$args = array_slice( func_get_args(), 1 );
	return call_user_func_array(array( &$_Twoot_ToolKit_Support, $function ), $args );
}
}
?>
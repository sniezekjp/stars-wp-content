<?php
/*
*
* @package ThemeWoot
* @author ThemeWoot Team 
*
* This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://www.gnu.org/licenses/gpl-3.0.txt
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists( 'Twoot_ToolKit_Page') )
{
/**
 * ToolKit Settings Page Class
 *
 * Contains the main functions for Theme ToolKit, stores variables, and handles error messages
 *
 * @class Twoot_ToolKit
 * @version	1.0
 * @since 1.0
 * @package ThemeWoot
 * @author ThemeWoot Team 
 */
class Twoot_ToolKit_Page {
	/**
	* This method adds other methods to specific hooks within WordPress.
	* @since     1.0
	* @updated   1.0
	*
	*/
	public function __construct() 
	{
		 add_action( 'admin_menu', array( $this, 'toolkit_menu' ) );
		 add_action( 'admin_init', array( $this, 'toolkit_menu_page_init') );
		 add_action( 'admin_enqueue_scripts', array($this,'toolkit_css') );
	}


	 /**
	 * Adds CSS
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function toolkit_css() 
	 {
		 $screen = get_current_screen();

		 wp_register_style( 'twoot-style', TWOOT_TOOLKIT_URL . '/assets/css/style.css', false, TWOOT_TOOLKIT_VERSION, 'all' );

		 if ( in_array( $screen->id, array( 'toplevel_page_twoot_toolkit' ) ) ) {
			wp_enqueue_style( 'twoot-style' );
		 }
	 }



	 /**
	 * Adds the TookKits menu item
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function toolkit_menu() 
	 {
		 add_menu_page( TWOOT_TOOLKIT_NAME, esc_attr__( 'Twoot Toolkit', 'Twoot_Toolkit' ), 'manage_options', TWOOT_TOOLKIT_SLUG, array( $this, 'toolkit_menu_page' ), TWOOT_TOOLKIT_URL . '/assets/images/toolkit.png' );
	 }


	 /**
	 * Creates the page used to set options
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function toolkit_menu_page() 
	 {
		if ( ! current_user_can( 'manage_options' ) ) { wp_die( esc_attr__( 'You do not have sufficient permissions to access this page.', 'Twoot_Toolkit' ) ); }
		echo ( isset( $_GET[ 'settings-updated' ] ) ) ? '<div class="updated fade"><p><strong>' . esc_attr__( 'Settings Updated.', 'Twoot_Toolkit' ) . '</strong></p></div>' : '';
		?>
		<div class="wrap twoot-toolkit-page">
		<div id="icon-options-general" class="icon32"></div><h2 class="twoot-toolkit-page-title"><?php echo TWOOT_TOOLKIT_NAME; ?><span><?php esc_attr_e('Version: ', 'Twoot_Toolkit'); ?><?php echo TWOOT_TOOLKIT_VERSION; ?></span></h2>
		<form method="post" action="<?php echo admin_url( 'options.php' ); ?>">
		<?php echo settings_fields( TWOOT_TOOLKIT_SLUG ); ?>
		<?php echo do_settings_sections( TWOOT_TOOLKIT_SLUG ); ?>
		<?php submit_button(); ?>
		</form>
		</div>
		<?php
	 }


	 /**
	 * Creates the page used to set options
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function toolkit_menu_page_init() 
	 {
		register_setting( TWOOT_TOOLKIT_SLUG, TWOOT_TOOLKIT_OPTIONS );

		// Twitter
		add_settings_section( 'twitter_oauth_settings', esc_attr__( 'Twitter OAuth Settings', 'Twoot_Toolkit' ), array( &$this, '_section_twitter_oauth_settings' ), TWOOT_TOOLKIT_SLUG );
		add_settings_field( 'twitter_username', esc_attr__( 'Username', 'Twoot_Toolkit' ), array( &$this, '_field_twitter_username' ), TWOOT_TOOLKIT_SLUG, 'twitter_oauth_settings' );
		add_settings_field( 'twitter_ck', esc_attr__( 'Consumer Key', 'Twoot_Toolkit' ), array( &$this, '_field_twitter_consumer_key' ), TWOOT_TOOLKIT_SLUG, 'twitter_oauth_settings' );
		add_settings_field( 'twitter_cs', esc_attr__( 'Consumer Secret', 'Twoot_Toolkit' ), array( &$this, '_field_twitter_consumer_secret' ), TWOOT_TOOLKIT_SLUG, 'twitter_oauth_settings' );
		add_settings_field( 'twitter_at', esc_attr__( 'Access Token', 'Twoot_Toolkit' ), array( &$this, '_field_twitter_access_token' ), TWOOT_TOOLKIT_SLUG, 'twitter_oauth_settings' );
		add_settings_field( 'twitter_ats', esc_attr__( 'Access Token Secret', 'Twoot_Toolkit' ), array( &$this, '_field_twitter_access_token_secret' ), TWOOT_TOOLKIT_SLUG, 'twitter_oauth_settings' );

		// Flickr
		add_settings_section( 'flickr_settings', esc_attr__( 'Flickr Settings', 'Twoot_Toolkit' ), array( &$this, '_section_flickr_settings' ), TWOOT_TOOLKIT_SLUG );
		add_settings_field( 'flickr_id', esc_attr__( 'Flickr ID', 'Twoot_Toolkit' ), array( &$this, '_field_flickr_id' ), TWOOT_TOOLKIT_SLUG, 'flickr_settings' );

		// Dribbble
		add_settings_section( 'dribbble_settings', esc_attr__( 'Dribbble Settings', 'Twoot_Toolkit' ), '', TWOOT_TOOLKIT_SLUG );
		add_settings_field( 'dribbble_username', esc_attr__( 'Username', 'Twoot_Toolkit' ), array( &$this, '_field_dribbble_username' ), TWOOT_TOOLKIT_SLUG, 'dribbble_settings' );
	 }


	  /**
	 * Twitter Oauth Settings
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function _section_twitter_oauth_settings() 
	 {
		_e( '<p>From March 2013 Twitter requires authentication to access your tweets. Here are fields you need to fill if you want to use Twitter Widgets and Twitter Slider. <br /><br />
		 1). Login the site: <a href="https://dev.twitter.com" target="_blank">https://dev.twitter.com</a><br />
		 2). Go to: Your Accont => My applications => Create a new application. <br />
		 3). Go to the Application => Details => Create my access token. <br />
		 4). Go to the Application => OAuth Tool => OAuth settings.<br /><br /></p>', 'Twoot_Toolkit' );
	 }


	 /**
	 * Twitter Username
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function _field_twitter_username() 
	 {
		$options = get_option( TWOOT_TOOLKIT_OPTIONS );
		echo '<input type="text" class="regular-text" name="' . TWOOT_TOOLKIT_OPTIONS . '[twitter_username]" value="' . esc_attr( $options['twitter_username'] ) . '" />';
	 }


	  /**
	 * Twitter Consumer Key
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function _field_twitter_consumer_key() 
	 {
		$options = get_option( TWOOT_TOOLKIT_OPTIONS );
		echo '<textarea class="large-text code" id="' . TWOOT_TOOLKIT_OPTIONS . '[twitter_ck]" name="' . TWOOT_TOOLKIT_OPTIONS . '[twitter_ck]" rows="3" cols="50">'. esc_attr( $options['twitter_ck'] ) .'</textarea>';
	 }


	 /**
	 * Twitter Consumer Secret
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function _field_twitter_consumer_secret() 
	 {
		$options = get_option( TWOOT_TOOLKIT_OPTIONS );
		echo '<textarea class="large-text code" id="' . TWOOT_TOOLKIT_OPTIONS . '[twitter_cs]" name="' . TWOOT_TOOLKIT_OPTIONS . '[twitter_cs]" rows="3" cols="50">'. esc_attr( $options['twitter_cs'] ) .'</textarea>';
	 }


	 /**
	 * Twitter Access Token
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function _field_twitter_access_token() 
	 {
		$options = get_option( TWOOT_TOOLKIT_OPTIONS );
		echo '<textarea class="large-text code" id="' . TWOOT_TOOLKIT_OPTIONS . '[twitter_at]" name="' . TWOOT_TOOLKIT_OPTIONS . '[twitter_at]" rows="3" cols="50">'. esc_attr( $options['twitter_at'] ) .'</textarea>';
	 }


	 /**
	 * Twitter Access Token Secret
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function _field_twitter_access_token_secret() 
	 {
		$options = get_option( TWOOT_TOOLKIT_OPTIONS );
		echo '<textarea class="large-text code" id="' . TWOOT_TOOLKIT_OPTIONS . '[twitter_ats]" name="' . TWOOT_TOOLKIT_OPTIONS . '[twitter_ats]" rows="3" cols="50">'. esc_attr( $options['twitter_ats'] ) .'</textarea><br /><br />';
	 }


	 /**
	 * Flickr Settings
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function _section_flickr_settings() 
	 {
		echo '<a href="http://idgettr.com/" target="_blank">'.esc_attr__('Get your flickr id.', 'Twoot_Toolkit').'</a>';
	 }


	  /**
	 * Flickr ID
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function _field_flickr_id() 
	 {
		$options = get_option( TWOOT_TOOLKIT_OPTIONS );
		echo '<input type="text" class="regular-text" name="' . TWOOT_TOOLKIT_OPTIONS . '[flickr_id]" value="' . esc_attr( $options['flickr_id'] ) . '" />';
	 }


	 /**
	 * Dribbble Username
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function _field_dribbble_username() 
	 {
		$options = get_option( TWOOT_TOOLKIT_OPTIONS );
		echo '<input type="text" class="regular-text" name="' . TWOOT_TOOLKIT_OPTIONS . '[dribbble_username]" value="' . esc_attr( $options['dribbble_username'] ) . '" />';
	 }
}

new Twoot_ToolKit_Page();
}
?>
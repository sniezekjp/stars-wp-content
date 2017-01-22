<?php
/*
Plugin Name: STM Importer
Plugin URI: http://stylemixthemes.com/
Description: STM Importer
Author: Stylemix Themes
Author URI: http://stylemixthemes.com/
Text Domain: stm_importer
Version: 1.0
*/


add_action('admin_menu', 'stm_add_demo_import_page');

if ( ! function_exists('stm_add_demo_import_page'))
{
	function stm_add_demo_import_page()
	{
		add_theme_page( esc_html__( 'Demo Import', 'splash' ) , esc_html__( 'Demo Import', 'splash' ) , 'manage_options' , 'stm_demo_import' , 'stm_demo_import' );
	}
}

if ( !function_exists('stm_demo_import'))
{
	function stm_demo_import()
	{
		?>
		<div class="stm_message content" style="display:none;">
			<img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/spinner.gif" alt="spinner">
			<h1 class="stm_message_title"><?php esc_html_e('Importing Demo Content...', 'splash'); ?></h1>
			<p class="stm_message_text"><?php esc_html_e('Duration of demo content importing depends on your server speed.', 'splash'); ?></p>
		</div>

		<div class="stm_message success" style="display:none;">
			<p class="stm_message_text"><?php echo wp_kses( sprintf(__('Congratulations and enjoy <a href="%s" target="_blank">your website</a> now!', 'splash'), esc_url( home_url() )), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ); ?></p>
		</div>

		<form class="stm_importer" id="import_demo_data_form" action="?page=stm_demo_import" method="post">

			<div class="stm_importer_options">

				<div class="stm_importer_note">
					<strong><?php esc_html_e('Before installing the demo content, please NOTE:', 'splash'); ?></strong>
					<p><?php echo wp_kses( sprintf(__('Install the demo content only on a clean WordPress. Use <a href="%s" target="_blank">Reset WP</a> plugin to clean the current Theme.', 'splash'), 'https://wordpress.org/plugins/reset-wp/', esc_url( home_url() )), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ); ?></p>
					<p><?php esc_html_e('Remember that you will NOT get the images from live demo due to copyright / license reason.', 'splash'); ?></p>
				</div>
				<p class="stm_demo_button_align">
					<input class="button-primary size_big" type="submit" value="Import" id="import_demo_data">
				</p>
			</div>

		</form>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#import_demo_data_form').on('submit', function() {
					jQuery("html, body").animate({
						scrollTop: 0
					}, {
						duration: 300
					});
					jQuery('.stm_importer').slideUp(null, function(){
						jQuery('.stm_message.content').slideDown();
					});

					// Importing Content
					jQuery.ajax({
						type: 'POST',
						url: '<?php echo admin_url('admin-ajax.php'); ?>',
						data: jQuery(this).serialize()+'&action=stm_demo_import_content',
						success: function(){

							jQuery('.stm_message.content').slideUp();
							jQuery('.stm_message.success').slideDown();

						}
					});
					return false;
				});
			});
		</script>
		<?php
	}

	// Content Import
	function stm_demo_import_content() {
		set_time_limit( 0 );

		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			define( 'WP_LOAD_IMPORTERS', true );
		}

		update_option( 'shop_catalog_image_size', array('width' => 570, 'height' => 350) );
		update_option( 'shop_single_image_size', array('width' => 440, 'height' => 450) );
		update_option( 'shop_thumbnail_image_size', array('width' => 100, 'height' => 89) );

		add_image_size( 'shop_thumbnail', 100, 89, true );
		add_image_size( 'shop_catalog', 570, 350, true );
		add_image_size( 'shop_single', 440, 450, true );

		require_once( 'wordpress-importer/wordpress-importer.php' );

		$wp_import                    = new WP_Import();
		$wp_import->fetch_attachments = true;

		ob_start();
			$wp_import->import( get_template_directory() . '/includes/demo/demo_content.xml' );
		ob_end_clean();

		do_action( 'splash_importer_done' );

		echo 'done';
		die();

	}

	add_action( 'wp_ajax_stm_demo_import_content', 'stm_demo_import_content' );

}
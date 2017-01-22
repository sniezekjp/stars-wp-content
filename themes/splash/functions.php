<?php
$splash_inc_path = get_template_directory() . '/includes';
$splash_partials_path = get_template_directory() . '/partials';
$splash_widgets_path = get_template_directory() . '/includes/widgets';

define( 'STM_CUSTOMIZER_PATH', get_template_directory() . '/includes/customizer' );
define( 'STM_CUSTOMIZER_URI', get_template_directory_uri() . '/includes/customizer' );

//Theme options.
require_once (STM_CUSTOMIZER_PATH . '/customizer.class.php');

// Custom code and theme main setups.
require_once( $splash_inc_path . '/setup.php' );

// Enqueue scripts and styles for theme.
require_once( $splash_inc_path . '/enqueue.php' );

// Custom code for any outputs modifying.
require_once( $splash_inc_path . '/custom.php' );

// Required plugins for the theme.
require_once( $splash_inc_path . '/tgm/tgm-plugin-registration.php' );

// Visual composer custom modules
if ( defined( 'WPB_VC_VERSION' ) ) {
	require_once( $splash_inc_path . '/visual_composer.php' );
}

/*Woocommerce setups*/
if( class_exists( 'WooCommerce' ) ) {
	require_once( $splash_inc_path . '/woocommerce.php' );
}

/*Partials functions*/
/*Media single*/
require_once( $splash_partials_path . '/loop/media-content.php' );

/*WIDGETS*/
require_once( $splash_widgets_path . '/contacts.php' );

require_once( $splash_widgets_path . '/recent_posts.php' );
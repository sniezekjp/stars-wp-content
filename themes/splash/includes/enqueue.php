<?php
define( 'STM_THEME_VERSION', ( WP_DEBUG ) ? time() : wp_get_theme()->get( 'Version' ) );

if ( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'splash_enqueue_scripts_styles', 5 );
}

function splash_enqueue_scripts_styles() {
	$template_path = get_template_directory_uri();

	$typography_body_font_family    = get_theme_mod( 'typography_body_font_family' );
	$typography_heading_font_family = get_theme_mod( 'typography_heading_font_family' );
	if ( empty( $typography_body_font_family ) or empty($typography_heading_font_family)) {
		wp_enqueue_style(
			'stm_default_google_font',
			splash_default_google_fonts_enqueue(),
			null,
			STM_THEME_VERSION,
			'all'
		);
	}

	// Styles
	wp_enqueue_style( 'boostrap', $template_path . '/assets/css/bootstrap.min.css', null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'select2', $template_path . '/assets/css/select2.min.css', null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'owl-carousel', $template_path . '/assets/css/owl.carousel.css', null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'stm-font-awesome', $template_path . '/assets/css/font-awesome.min.css', null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'fancybox', $template_path . '/assets/css/jquery.fancybox.css', null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'stm-theme-animate', $template_path.'/assets/css/animate.css', null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'stm-theme-icons', $template_path.'/assets/css/splash-icons.css', null, STM_THEME_VERSION, 'all' );

	if ( get_theme_mod( 'frontend_customizer' ) ) {
		wp_enqueue_style( 'stm-frontend_customizer', $template_path . '/assets/css/frontend_customizer.css', null, STM_THEME_VERSION, 'all' );
	}

	$upload_dir = wp_upload_dir();
	$stm_upload_dir = $upload_dir['baseurl'] . '/stm_uploads';
	$skin = get_theme_mod('site_style', 'default');

	if($skin == 'default' or $skin == 'site_style_custom') {
		if ( is_dir( $upload_dir['basedir'] . '/stm_uploads' ) and $skin != 'default' ) {
			wp_enqueue_style( 'stm-skin-custom', $stm_upload_dir . '/skin-custom.css', null, STM_THEME_VERSION, 'all' );
		} else {
			wp_enqueue_style( 'stm-theme-style', $template_path . '/assets/css/styles.css', null, STM_THEME_VERSION, 'all' );
		}
	} else {
		wp_enqueue_style( 'stm-theme-style-prepackaged', $template_path . '/assets/css/skins/skin-custom-' . $skin . '.css', null, STM_THEME_VERSION, 'all' );
	}

	wp_enqueue_style( 'stm-theme-default-styles', $template_path.'/style.css', null, STM_THEME_VERSION, 'all' );


	// THEME SCRIPTS
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$google_api_key = get_theme_mod( 'google_api_key', '' );
	if( !empty($google_api_key) ) {
		$google_api_map = 'https://maps.googleapis.com/maps/api/js?key='.$google_api_key.'&';
	} else {
		$google_api_map = 'https://maps.googleapis.com/maps/api/js?';
	}
	wp_register_script( 'stm_gmap', $google_api_map, array( 'jquery' ), STM_THEME_VERSION, true );
	wp_enqueue_script( 'stm_gmap' );

	wp_register_script( 'stm-theme-ticker', $template_path . '/assets/js/ticker.js', array( 'jquery' ), STM_THEME_VERSION, true );
	wp_enqueue_script( 'bootstrap', $template_path . '/assets/js/bootstrap.min.js', array( 'jquery' ), STM_THEME_VERSION, true );
	wp_enqueue_script( 'select2', $template_path . '/assets/js/select2.full.min.js', array( 'jquery' ), STM_THEME_VERSION, true );
	wp_enqueue_script( 'owl-carousel', $template_path . '/assets/js/owl.carousel.min.js', array( 'jquery' ), STM_THEME_VERSION, true );
	wp_enqueue_script( 'fancybox', $template_path . '/assets/js/jquery.fancybox.pack.js', array( 'jquery' ), STM_THEME_VERSION, true );
	wp_enqueue_script( 'imagesloaded', $template_path . '/assets/js/imagesloaded.pkgd.min.js', array( 'jquery' ), STM_THEME_VERSION, true );
	wp_enqueue_script( 'isotope', $template_path . '/assets/js/isotope.pkgd.min.js', array( 'jquery' ), STM_THEME_VERSION, true );
	wp_enqueue_script( 'stm-theme-scripts', $template_path . '/assets/js/splash.js', array( 'jquery' ), STM_THEME_VERSION, true );
	wp_enqueue_script( 'stm-theme-scripts-header', $template_path . '/assets/js/header.js', array( 'jquery' ), STM_THEME_VERSION, true );

	$smooth_scroll = get_theme_mod( 'smooth_scroll', false );
	if( !empty($smooth_scroll) and $smooth_scroll) {
		wp_enqueue_script( 'stm-smooth-scroll', $template_path . '/assets/js/smoothScroll.js', array( 'jquery' ), STM_THEME_VERSION, true );
	}

	if(is_singular('product')) {
		wp_enqueue_script( 'jcarousel', $template_path . '/assets/js/jcarousel.min.js', array( 'jquery' ), STM_THEME_VERSION, false );
	}
}

function splash_admin_styles() {
	$template_path = get_template_directory_uri();

	wp_enqueue_style( 'stm-theme-admin-styles', $template_path . '/assets/css/admin.css', null, STM_THEME_VERSION, 'all' );
	wp_enqueue_style( 'select2', $template_path . '/assets/css/select2.min.css', null, STM_THEME_VERSION, 'all' );
	wp_enqueue_script( 'jquery.multiselect', $template_path . '/assets/js/jquery.multi-select.js', 'jquery', STM_THEME_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'splash_admin_styles' );


// Default Google fonts enqueue
if( !function_exists('splash_default_google_fonts_enqueue')) {
	function splash_default_google_fonts_enqueue() {
		$fonts_url = '';

		$montserrat = _x( 'on', 'Roboto Condensed font: on or off', 'splash' );
		$open_sans = _x( 'on', 'Roboto font: on or off', 'splash' );

		if ( 'off' !== $montserrat || 'off' !== $open_sans ) {
			$font_families = array();

			if ( 'off' !== $montserrat ) {
				$font_families[] = 'Roboto+Condensed:400,700,300';
			}

			if ( 'off' !== $open_sans ) {
				$font_families[] = 'Roboto:500,400,300,400italic,700';
			}

			$query_args = array(
				'family' =>  implode( '|', $font_families )
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url( $fonts_url );
	}
}
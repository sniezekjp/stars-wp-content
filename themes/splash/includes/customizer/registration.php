<?php

add_action('init', 'stm_customizer_init');

function stm_customizer_init() {
	$socials = array(
		'facebook'     => esc_html__( 'Facebook', 'splash' ),
		'twitter'      => esc_html__( 'Twitter', 'splash' ),
		'vk'           => esc_html__( 'VK', 'splash' ),
		'instagram'    => esc_html__( 'Instagram', 'splash' ),
		'behance'      => esc_html__( 'Behance', 'splash' ),
		'dribbble'     => esc_html__( 'Dribbble', 'splash' ),
		'flickr'       => esc_html__( 'Flickr', 'splash' ),
		'git'          => esc_html__( 'Git', 'splash' ),
		'linkedin'     => esc_html__( 'Linkedin', 'splash' ),
		'pinterest'    => esc_html__( 'Pinterest', 'splash' ),
		'yahoo'        => esc_html__( 'Yahoo', 'splash' ),
		'delicious'    => esc_html__( 'Delicious', 'splash' ),
		'dropbox'      => esc_html__( 'Dropbox', 'splash' ),
		'reddit'       => esc_html__( 'Reddit', 'splash' ),
		'soundcloud'   => esc_html__( 'Soundcloud', 'splash' ),
		'google'       => esc_html__( 'Google', 'splash' ),
		'google-plus'  => esc_html__( 'Google +', 'splash' ),
		'skype'        => esc_html__( 'Skype', 'splash' ),
		'youtube'      => esc_html__( 'Youtube', 'splash' ),
		'youtube-play' => esc_html__( 'Youtube Play', 'splash' ),
		'tumblr'       => esc_html__( 'Tumblr', 'splash' ),
		'whatsapp'     => esc_html__( 'Whatsapp', 'splash' ),
	);

	$statistics       = get_posts( array( 'post_type' => 'sp_performance', 'posts_per_page' => 9999 ) );
	$statistics_array = array();
	if ( $statistics ) {
		foreach ( $statistics as $statistic ) {
			$statistics_array[ $statistic->ID ] = $statistic->post_title;
		}
	}

	/*Leagues categories*/
	$leagues = get_terms( 'sp_league' );
	$leagues_array = array();

	if(!empty($leagues) and !is_wp_error($leagues)) {
		foreach ( $leagues as $league ) {
			$leagues_array[ $league->term_id ] = $league->name;
		}
	}

	/*Season categories*/
	$seasons       = get_terms( 'sp_season' );
	$seasons_array = array();

	if(!empty($seasons) and !is_wp_error($seasons)) {
		foreach ( $seasons as $season ) {
			$seasons_array[ $season->term_id ] = $season->name;
		}
	}

	$positions = array(
		'left'  => esc_html__( 'Left', 'splash' ),
		'right' => esc_html__( 'Right', 'splash' ),
	);

	STM_Customizer::setPanels( array(
		'site_settings' => array(
			'title'    => esc_html__( 'Site Settings', 'splash' ),
			'priority' => 10
		),
		'header'        => array(
			'title'    => esc_html__( 'Header', 'splash' ),
			'priority' => 20
		),
		'footer'        => array(
			'title'    => esc_html__( 'Footer', 'splash' ),
			'priority' => 50
		),
		'sportspress'   => array(
			'title'    => esc_html__( 'SportsPress', 'splash' ),
			'priority' => 30
		)
	) );

	STM_Customizer::setSection( 'title_tagline', array(
		'title'    => esc_html__( 'Logo &amp; Title', 'splash' ),
		'panel'    => 'site_settings',
		'priority' => 200,
		'fields'   => array(
			'logo'           => array(
				'label' => esc_html__( 'Logo', 'splash' ),
				'type'  => 'image',
			),
			'logo_width'     => array(
				'label' => esc_html__( 'Logo Width (px)', 'splash' ),
				'type'  => 'text'
			),
			'logo_break_2'   => array(
				'type' => 'stm-separator',
			),
			'logo_font_size' => array(
				'label'  => esc_html__( 'Text Logo Font Size', 'splash' ),
				'type'   => 'stm-attr',
				'mode'   => 'font-size',
				'units'  => 'px',
				'min'    => '0',
				'max'    => '30',
				'output' => '.stm-header .logo-main .blogname h1'
			),
			'logo_color'     => array(
				'label'     => esc_html__( 'Text Logo Color', 'splash' ),
				'type'      => 'color',
				'output'    => array( 'color' => '.stm-header .logo-main .blogname h1' ),
				'transport' => 'postMessage',
				'default'   => '#fff'
			),
		)
	) );

	STM_Customizer::setSection( 'site_settings', array(
		'title'    => esc_html__( 'One Click update', 'splash' ),
		'panel'    => 'site_settings',
		'priority' => 250,
		'fields'   => array(
			'envato_username' => array(
				'label'       => esc_html__( 'Envato Username', 'splash' ),
				'type'        => 'text',
				'default'     => '',
				'description' => esc_html__( 'Enter here your ThemeForest (or Envato) username account (i.e. Stylemixthemes).', 'splash' )
			),
			'envato_api'      => array(
				'label'       => esc_html__( 'Envato API Key', 'splash' ),
				'type'        => 'text',
				'default'     => '',
				'description' => esc_html__( 'Enter here the secret api key you have created on ThemeForest. You can create a new one in the Settings > API Keys section of your profile.', 'splash' )
			),
		)
	) );

	STM_Customizer::setSection( 'google_api_settings', array(
		'title'    => esc_html__( 'Google Api Settings', 'splash' ),
		'panel'    => 'site_settings',
		'priority' => 300,
		'fields'   => array(
			'google_api_key' => array(
				'label' => esc_html__( 'Google API Key', 'splash' ),
				'type'  => 'text',
				'description' => esc_html__( 'Enter here the secret api key you have created on Google APIs. You can enable MAP API in Google APIs > Google Maps APIs > Google Maps JavaScript API.', 'splash' )
			),
		)
	) );

	STM_Customizer::setSection( 'site_style', array(
		'title'    => esc_html__( 'Style', 'splash' ),
		'panel'    => 'site_settings',
		'priority' => 220,
		'fields'   => array(
			'site_bg_color'              => array(
				'label'     => esc_html__( 'Site background color', 'splash' ),
				'type'      => 'color',
				'output'    => array( 'background-color' => '#wrapper' ),
				'transport' => 'postMessage',
			),
			'site_style'                 => array(
				'label'   => esc_html__( 'Style', 'splash' ),
				'type'    => 'stm-select',
				'choices' => array(
					'default' => esc_html__( 'Default', 'splash' ),
					'blue'    => esc_html__( 'Blue', 'splash' ),
					'blue-violet'    => esc_html__( 'Blue Violet', 'splash' ),
					'choco'    => esc_html__( 'Choco', 'splash' ),
					'gold'    => esc_html__( 'Gold', 'splash' ),
					'green'    => esc_html__( 'Green', 'splash' ),
					'orange'    => esc_html__( 'Orange', 'splash' ),
					'sky-blue'    => esc_html__( 'Sky blue', 'splash' ),
					'turquose'    => esc_html__( 'Turquoise', 'splash' ),
					'violet-red'    => esc_html__( 'Violet Red', 'splash' ),
					'site_style_custom'  => esc_html__( 'Custom Color', 'splash' ),
				),
				'default' => 'default'
			),
			'site_style_base_color'      => array(
				'label'   => esc_html__( 'Custom Base Color', 'splash' ),
				'type'    => 'color',
				'default' => '#e21e22'
			),
			'site_boxed'                 => array(
				'label'   => esc_html__( 'Enable Boxed Layout', 'splash' ),
				'type'    => 'stm-checkbox',
				'default' => false
			),
			'bg_image'                   => array(
				'label'   => esc_html__( 'Background Image', 'splash' ),
				'type'    => 'stm-bg',
				'choices' => array(
					'5' => 'box_img_5_preview.png',
					'1' => 'box_img_1_preview.png',
					'2' => 'box_img_2_preview.png',
					'3' => 'box_img_3_preview.jpg',
					'4' => 'box_img_4_preview.jpg',
				)
			),
			'custom_bg_image'            => array(
				'label' => esc_html__( 'Custom Bg Image', 'splash' ),
				'type'  => 'image'
			),
			'custom_bg_pattern'            => array(
				'label' => esc_html__( 'Custom Bg Image Pattern', 'splash' ),
				'type'  => 'image'
			),
			'frontend_customizer'        => array(
				'label'   => esc_html__( 'Frontend Customizer', 'splash' ),
				'type'    => 'stm-checkbox',
				'default' => false
			),
			'smooth_scroll'              => array(
				'label'   => esc_html__( 'Site smooth scroll', 'splash' ),
				'type'    => 'stm-checkbox',
				'default' => false
			),
		)
	) );

	//Typography
	STM_Customizer::setSection( 'typography', array(
		'title'    => esc_html__( 'Typography', 'splash' ),
		'panel'    => 'site_settings',
		'priority' => 230,
		'fields'   => array(

			'typography_body_font_family'    => array(
				'label'  => esc_html__( 'Body Font Family', 'splash' ),
				'type'   => 'stm-font-family',
				'output' => 'body, .normal-font',
			),
			'typography_body_font_size'      => array(
				'label'   => esc_html__( 'Body Font Size', 'splash' ),
				'type'    => 'stm-attr',
				'mode'    => 'font-size',
				'units'   => 'px',
				'min'     => '0',
				'max'     => '30',
				'output'  => 'body, .normal_font',
				'default' => '15'
			),
			'typography_body_line_height'    => array(
				'label'   => esc_html__( 'Body Line Height', 'splash' ),
				'type'    => 'stm-attr',
				'units'   => 'px',
				'mode'    => 'line-height',
				'output'  => 'body, .normal_font',
				'default' => '24'
			),
			'typography_body_color'          => array(
				'label'     => esc_html__( 'Body Font Color', 'splash' ),
				'type'      => 'color',
				'output'    => array( 'color' => 'body, .normal_font, .stm-single-post-loop-content' ),
				'transport' => 'postMessage',
				'default'   => '#000'
			),
			'typography_break_1'             => array(
				'type' => 'stm-separator',
			),
			'typography_break_2'             => array(
				'type' => 'stm-separator',
			),
			'typography_heading_font_family' => array(
				'label'  => esc_html__( 'Headings Font Family', 'splash' ),
				'type'   => 'stm-font-family',
				'output' => 'h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6, .heading-font, .button, .widget_recent_entries,.menu-widget-menu-container li, table, .stm-widget-menu ul.menu li a'
			),
			'typography_heading_color'       => array(
				'label'     => esc_html__( 'Headings Color', 'splash' ),
				'type'      => 'color',
				'output'    => array( 'color' => 'h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6, .heading-font, .widget_recent_entries,.menu-widget-menu-container li, table' ),
				'transport' => 'postMessage',
				'default'   => '#232628'
			),
			'typography_h1_font_size'        => array(
				'label'   => esc_html__( 'H1 Font Size', 'splash' ),
				'type'    => 'stm-attr',
				'mode'    => 'font-size',
				'units'   => 'px',
				'min'     => '0',
				'max'     => '50',
				'output'  => 'h1, .h1',
				'default' => '50'
			),
			'typography_h2_font_size'        => array(
				'label'   => esc_html__( 'H2 Font Size', 'splash' ),
				'type'    => 'stm-attr',
				'mode'    => 'font-size',
				'units'   => 'px',
				'min'     => '0',
				'max'     => '50',
				'output'  => 'h2, .h2',
				'default' => '36'
			),
			'typography_h3_font_size'        => array(
				'label'   => esc_html__( 'H3 Font Size', 'splash' ),
				'type'    => 'stm-attr',
				'mode'    => 'font-size',
				'units'   => 'px',
				'min'     => '0',
				'max'     => '50',
				'output'  => 'h3, .h3',
				'default' => '30'
			),
			'typography_h4_font_size'        => array(
				'label'   => esc_html__( 'H4 Font Size', 'splash' ),
				'type'    => 'stm-attr',
				'mode'    => 'font-size',
				'units'   => 'px',
				'min'     => '0',
				'max'     => '50',
				'output'  => 'h4, .h4',
				'default' => '24'
			),
			'typography_h5_font_size'        => array(
				'label'   => esc_html__( 'H5 Font Size', 'splash' ),
				'type'    => 'stm-attr',
				'mode'    => 'font-size',
				'units'   => 'px',
				'min'     => '0',
				'max'     => '50',
				'output'  => 'h5, .h5',
				'default' => '18'
			),
			'typography_h6_font_size'        => array(
				'label'   => esc_html__( 'H6 Font Size', 'splash' ),
				'type'    => 'stm-attr',
				'mode'    => 'font-size',
				'units'   => 'px',
				'min'     => '0',
				'max'     => '50',
				'output'  => 'h6, .h6',
				'default' => '14'
			),
		)
	) );

	STM_Customizer::setSection( 'static_front_page', array(
		'title'    => esc_html__( 'Static Front Page', 'splash' ),
		'panel'    => 'site_settings',
		'priority' => 190,
	) );

	STM_Customizer::setSection( 'header_top_bar', array(
		'title'  => esc_html__( 'Top bar', 'splash' ),
		'panel'  => 'header',
		'fields' => array(
			'top_bar_enable'          => array(
				'label'             => esc_html__( 'Top bar Enabled', 'splash' ),
				'type'              => 'stm-checkbox',
				'sanitize_callback' => 'sanitize_checkbox',
				'default'           => true
			),
			'top_bar_bg_color'        => array(
				'label'     => esc_html__( 'Top bar Background Color', 'splash' ),
				'type'      => 'color',
				'output'    => array( 'background-color' => '#stm-top-bar' ),
				'transport' => 'postMessage',
				'default'   => '#151515'
			),
			'top_bar_text_color'      => array(
				'label'     => esc_html__( 'Top bar Text Color', 'splash' ),
				'type'      => 'color',
				'output'    => array( 'color' => '#stm-top-bar' ),
				'transport' => 'postMessage',
				'default'   => '#fff'
			),
			'top_bar_enable_ticker'   => array(
				'label'             => esc_html__( 'Top bar enable news ticker', 'splash' ),
				'type'              => 'stm-checkbox',
				'sanitize_callback' => 'sanitize_checkbox',
				'default'           => true
			),
			'top_bar_ticker_title'    => array(
				'label'   => esc_html__( 'Ticker title', 'splash' ),
				'type'    => 'text',
				'default' => esc_html__( 'Breaking news', 'splash' ),
			),
			'top_bar_enable_socials'  => array(
				'label'             => esc_html__( 'Top bar enable socials', 'splash' ),
				'type'              => 'stm-checkbox',
				'sanitize_callback' => 'sanitize_checkbox',
				'default'           => true
			),
			'top_bar_enable_switcher' => array(
				'label'             => esc_html__( 'Top bar enable WPML switcher', 'splash' ),
				'type'              => 'stm-checkbox',
				'sanitize_callback' => 'sanitize_checkbox',
				'default'           => true
			),
			'top_bar_enable_cart'     => array(
				'label'             => esc_html__( 'Top bar enable Cart woocommerce', 'splash' ),
				'type'              => 'stm-checkbox',
				'sanitize_callback' => 'sanitize_checkbox',
				'default'           => true
			),

		)
	) );

	STM_Customizer::setSection( 'top_bar_socials', array(
		'title'  => esc_html__( 'Top Bar Socials', 'splash' ),
		'panel'  => 'header',
		'fields' => array(
			'top_bar_socials' => array(
				'label'   => esc_html__( 'Top bar Socials', 'splash' ),
				'type'    => 'stm-multiple-checkbox',
				'choices' => $socials
			),
		)
	) );

	STM_Customizer::setSection( 'header_settings', array(
		'title'  => esc_html__( 'Header Appearance', 'splash' ),
		'panel'  => 'header',
		'fields' => array(
			'header_position'                 => array(
				'label'   => esc_html__( 'Enable Sticky Header', 'splash' ),
				'type'    => 'stm-checkbox',
				'default' => false
			),
			'header_background'    => array(
				'label' => esc_html__( 'Header Background', 'splash' ),
				'type'  => 'image',
			),
			'menu_top_margin'      => array(
				'label' => esc_html__( 'Menu margin top (px)', 'splash' ),
				'type'  => 'text',
			),
			'logo_top_margin'      => array(
				'label'   => esc_html__( 'Logo margin top (px)', 'splash' ),
				'type'    => 'text',
				'default' => '22'
			),
			'header_enable_search' => array(
				'label'             => esc_html__( 'Enable Search', 'splash' ),
				'type'              => 'stm-checkbox',
				'sanitize_callback' => 'sanitize_checkbox',
				'default'           => true
			),
		)
	) );

	STM_Customizer::setSection( 'footer_layout', array(
		'title'  => esc_html__( 'Main settings', 'splash' ),
		'panel'  => 'footer',
		'fields' => array(
			'footer_image'      => array(
				'label' => esc_html__( 'Footer Image', 'splash' ),
				'type'  => 'image',
			),
			'footer_ca_text'         => array(
				'label'   => esc_html__( 'Footer Call to action text', 'splash' ),
				'type'    => 'text',
			),
			'footer_ca_link_text'         => array(
				'label'   => esc_html__( 'Footer Call to action link text', 'splash' ),
				'type'    => 'text',
			),
			'footer_ca_link'         => array(
				'label'   => esc_html__( 'Footer Call to action link', 'splash' ),
				'type'    => 'text',
			),
			'footer_ca_position' => array(
				'label'   => esc_html__( 'Footer Call to action text position', 'splash' ),
				'type'    => 'stm-select',
				'choices' => array(
					'center' => esc_html__( 'Center', 'splash' ),
					'left'    => esc_html__( 'Left', 'splash' ),
					'right'  => esc_html__( 'Right', 'splash' ),
				),
				'default' => 'center'
			),
			'footer_bg_color'   => array(
				'label'     => esc_html__( 'Footer background color', 'splash' ),
				'type'      => 'color',
				'output'    => array( 'background-color' => '.footer-widgets-wrapper' ),
				'transport' => 'postMessage',
			),
			'footer_text_color' => array(
				'label'     => esc_html__( 'Footer Bottom text color', 'splash' ),
				'type'      => 'color',
				'output'    => array( 'color' => '.footer-widgets-wrapper, .footer-widgets-wrapper a, .footer-widgets-wrapper li, .footer-widgets-wrapper caption' ),
				'transport' => 'postMessage',
			),
		)
	) );

	STM_Customizer::setSection( 'footer_bottom', array(
		'title'  => esc_html__( 'Footer bottom', 'splash' ),
		'panel'  => 'footer',
		'fields' => array(
			'enable_footer_bottom'     => array(
				'label'   => esc_html__( 'Enable Footer Bottom', 'splash' ),
				'type'    => 'stm-checkbox',
				'default' => true
			),
			'footer_bottom_bg_color'   => array(
				'label'     => esc_html__( 'Footer Bottom background color', 'splash' ),
				'type'      => 'color',
				'output'    => array( 'background-color' => '#stm-footer-bottom' ),
				'transport' => 'postMessage',
			),
			'footer_bottom_text_color' => array(
				'label'     => esc_html__( 'Footer Bottom text color', 'splash' ),
				'type'      => 'color',
				'output'    => array( 'color' => '#stm-footer-bottom, #stm-footer-bottom a' ),
				'transport' => 'postMessage',
			),
			'footer_left_text'         => array(
				'label'   => esc_html__( 'Left text', 'splash' ),
				'type'    => 'text',
				'default' => esc_html__( 'Copyright (c) 2016 Splash.', 'splash' )
			),
			'footer_right_text'        => array(
				'label'   => esc_html__( 'Right text', 'splash' ),
				'type'    => 'text',
				'default' => esc_html__( 'Theme by Stylemix Themes.', 'splash' )
			),
			'footer_socials_text'      => array(
				'label'   => esc_html__( 'Socials text', 'splash' ),
				'type'    => 'text',
				'default' => esc_html__( 'Follow Us:', 'splash' )
			),
			'footer_socials'           => array(
				'label'   => esc_html__( 'Socials', 'splash' ),
				'type'    => 'stm-multiple-checkbox',
				'choices' => $socials
			),
		)
	) );

	// Get sidebar posts
	$sidebars = array(
		'no_sidebar'      => esc_html__( 'Without sidebar', 'splash' ),
		'primary_sidebar' => esc_html__( 'Primary sidebar', 'splash' ),
	);

	$query = get_posts( array( 'post_type' => 'vc_sidebar', 'posts_per_page' => - 1 ) );

	if ( $query ) {
		foreach ( $query as $post ) {
			$sidebars[ $post->ID ] = get_the_title( $post->ID );
		}
	}


	STM_Customizer::setSection( 'blog', array(
		'title'    => esc_html__( 'Blog', 'splash' ),
		'priority' => 40,
		'fields'   => array(
			'view_type'        => array(
				'label'   => esc_html__( 'View type', 'splash' ),
				'type'    => 'radio',
				'choices' => array(
					'grid' => esc_html__( 'Grid', 'splash' ),
					'list' => esc_html__( 'List', 'splash' )
				),
				'default' => 'grid'
			),
			'sidebar'          => array(
				'label'   => esc_html__( 'Choose archive sidebar', 'splash' ),
				'type'    => 'stm-select',
				'choices' => $sidebars,
				'default' => 'primary_sidebar'
			),
			'sidebar_blog'     => array(
				'label'   => esc_html__( 'Choose default sidebar for single blog post', 'splash' ),
				'type'    => 'stm-select',
				'choices' => $sidebars,
				'default' => 'primary_sidebar'
			),
			'sidebar_position' => array(
				'label'   => esc_html__( 'Sidebar position', 'splash' ),
				'type'    => 'radio',
				'choices' => array(
					'left'  => esc_html__( 'Left', 'splash' ),
					'right' => esc_html__( 'Right', 'splash' )
				),
				'default' => 'left'
			),
		)
	) );

	STM_Customizer::setSection( 'donations', array(
		'title'    => esc_html__( 'Donations', 'splash' ),
		'priority' => 45,
		'fields'   => array(
			'donation_sidebar'          => array(
				'label'   => esc_html__( 'Choose sidebar', 'splash' ),
				'type'    => 'stm-select',
				'choices' => $sidebars,
				'default' => 'primary_sidebar'
			),
			'donation_sidebar_position' => array(
				'label'   => esc_html__( 'Sidebar position', 'splash' ),
				'type'    => 'radio',
				'choices' => array(
					'left'  => esc_html__( 'Left', 'splash' ),
					'right' => esc_html__( 'Right', 'splash' )
				),
				'default' => 'left'
			),
			'donation_break'            => array(
				'type' => 'stm-separator',
			),
			'donation_raised'           => array(
				'label'   => esc_html__( 'Raised money text', 'splash' ),
				'type'    => 'text',
				'default' => esc_html__( 'Raised', 'splash' )
			),
			'donation_donors'           => array(
				'label'   => esc_html__( 'Donors text', 'splash' ),
				'type'    => 'text',
				'default' => esc_html__( 'Donors', 'splash' )
			),
			'donation_goal'             => array(
				'label'   => esc_html__( 'Goal text', 'splash' ),
				'type'    => 'text',
				'default' => esc_html__( 'Goal', 'splash' )
			),
			'donation_currency'         => array(
				'label'   => esc_html__( 'Donation Currency', 'splash' ),
				'type'    => 'text',
				'default' => esc_html__( '$', 'splash' )
			),
			'donation_break_2'          => array(
				'type' => 'stm-separator',
			),
			'paypal_currency'           => array(
				'label'       => esc_html__( 'Paypal Currency', 'splash' ),
				'type'        => 'text',
				'default'     => esc_html__( 'USD', 'splash' ),
				'description' => esc_html__( 'Ex.: USD', 'splash' ),
			),
			'paypal_email'              => array(
				'label'   => esc_html__( 'Paypal Email', 'splash' ),
				'type'    => 'text',
				'default' => '',
			),
			'paypal_mode'               => array(
				'label'   => esc_html__( 'Paypal mode', 'splash' ),
				'type'    => 'stm-select',
				'choices' => array(
					'sandbox' => esc_html__( 'Sandbox', 'splash' ),
					'live'    => esc_html__( 'Live', 'splash' ),
				),
				'default' => 'sandbox'
			),
			'donation_break_3'          => array(
				'type' => 'stm-separator',
			),
			'admin_email_subject'       => array(
				'label'   => esc_html__( 'Admin E-mail subject', 'splash' ),
				'type'    => 'text',
				'default' => esc_html__( 'New Donation for [donation]', 'splash' ),
			),
			'admin_email_message'       => array(
				'label'   => esc_html__( 'Admin E-mail Message', 'splash' ),
				'type'    => 'text',
				'default' => esc_html__( 'New payment for [donation]. Donor Info: Name:[name]; Phone:[phone]; E-mail:[email]; Amount:[amount]', 'splash' ),
			),
			'user_email_subject'        => array(
				'label'   => esc_html__( 'User E-mail subject', 'splash' ),
				'type'    => 'text',
				'default' => esc_html__( 'Confirmation of donation for [donation]', 'splash' ),
			),
			'user_email_message'        => array(
				'label'   => esc_html__( 'User E-mail text', 'splash' ),
				'type'    => 'text',
				'default' => esc_html__( 'Dear [name]. Thank you for your donation.', 'splash' ),
			),
		)
	) );

	STM_Customizer::setSection( 'pages', array(
		'title'    => esc_html__( 'Pages', 'splash' ),
		'priority' => 41,
		'fields'   => array(
			'pages_show_title'       => array(
				'label'   => esc_html__( 'Show page title', 'splash' ),
				'type'    => 'checkbox',
				'default' => true,
			),
			'pages_show_breadcrumbs' => array(
				'label'   => esc_html__( 'Show page breadcrumbs', 'splash' ),
				'type'    => 'checkbox',
				'default' => true,
			),
		)
	) );

	STM_Customizer::setSection( 'blog', array(
		'title'    => esc_html__( 'Blog', 'splash' ),
		'priority' => 45,
		'fields'   => array(
			'view_type'        => array(
				'label'   => esc_html__( 'View type', 'splash' ),
				'type'    => 'radio',
				'choices' => array(
					'grid' => esc_html__( 'Grid', 'splash' ),
					'list' => esc_html__( 'List', 'splash' )
				),
				'default' => 'grid'
			),
			'sidebar'          => array(
				'label'   => esc_html__( 'Choose archive sidebar', 'splash' ),
				'type'    => 'stm-select',
				'choices' => $sidebars,
				'default' => 'primary_sidebar'
			),
			'sidebar_blog'     => array(
				'label'   => esc_html__( 'Choose default sidebar for single blog post', 'splash' ),
				'type'    => 'stm-select',
				'choices' => $sidebars,
				'default' => 'primary_sidebar'
			),
			'sidebar_position' => array(
				'label'   => esc_html__( 'Sidebar position', 'splash' ),
				'type'    => 'radio',
				'choices' => array(
					'left'  => esc_html__( 'Left', 'splash' ),
					'right' => esc_html__( 'Right', 'splash' )
				),
				'default' => 'right'
			),
		)
	) );

	STM_Customizer::setSection( 'media', array(
		'title'    => esc_html__( 'Media', 'splash' ),
		'priority' => 47,
		'fields'   => array(
			'media_sidebar'          => array(
				'label'   => esc_html__( 'Choose media sidebar', 'splash' ),
				'type'    => 'stm-select',
				'choices' => $sidebars,
				'default' => 'no_sidebar'
			),
			'media_sidebar_position' => array(
				'label'   => esc_html__( 'Media Sidebar position', 'splash' ),
				'type'    => 'radio',
				'choices' => array(
					'left'  => esc_html__( 'Left', 'splash' ),
					'right' => esc_html__( 'Right', 'splash' )
				),
				'default' => 'right'
			),
		)
	) );

	STM_Customizer::setSection( 'sportpress_main', array(
		'title'    => esc_html__( 'SportsPress', 'splash' ),
		'panel'    => 'sportspress',
		'priority' => 48,
		'fields'   => array(
			'event_list_template'  => array(
				'label'       => esc_html__( 'Event list view', 'splash' ),
				'type'        => 'radio',
				'choices'     => array(
					'theme'       => esc_html__( 'Theme', 'splash' ),
					'sportspress' => esc_html__( 'Sportspress', 'splash' )
				),
				'default'     => 'theme',
				'description' => esc_html__( 'You can choose sportspress view, if you want to enable default plugin settings', 'splash' )
			),
			'event_block_template' => array(
				'label'       => esc_html__( 'Event block view', 'splash' ),
				'type'        => 'radio',
				'choices'     => array(
					'theme'       => esc_html__( 'Theme', 'splash' ),
					'sportspress' => esc_html__( 'Sportspress', 'splash' )
				),
				'default'     => 'theme',
				'description' => esc_html__( 'You can choose sportspress view, if you want to enable default plugin settings', 'splash' )
			),
			'sp_event_bg'            => array(
				'label' => esc_html__( 'Event Bg Image', 'splash' ),
				'type'  => 'image'
			),
		)
	) );

	STM_Customizer::setSection( 'single_player', array(
		'title'    => esc_html__( 'Single player', 'splash' ),
		'panel'    => 'sportspress',
		'priority' => 250,
		'fields'   => array(
			'player_title'        => array(
				'label'   => esc_html__( 'Hide player title', 'splash' ),
				'type'    => 'stm-checkbox',
				'default' => true
			),
			'single_player_season_stats'             => array(
				'label'       => esc_html__( 'Choose season', 'splash' ),
				'type'        => 'stm-select',
				'choices'     => $seasons_array,
				'description' => esc_html__( 'Statistics will be shown for this season', 'splash' ),
				'default'     => 11
			),
			'single_player_league_stats'             => array(
				'label'       => esc_html__( 'Choose league', 'splash' ),
				'type'        => 'stm-select',
				'choices'     => $leagues_array,
				'description' => esc_html__( 'Statistics will be shown for this league', 'splash' ),
				'default'     => 8
			),
			'single_player_stats' => array(
				'label'       => esc_html__( 'Show statistic', 'splash' ),
				'type'        => 'stm-multiple-checkbox',
				'choices'     => $statistics_array,
				'description' => esc_html__( 'This Statistic will be shown on single player page', 'splash' ),
				'default'     => '264,265,266,267'
			),

		)
	) );

	STM_Customizer::setSection( 'shop', array(
		'title'  => esc_html__( 'Shop', 'splash' ),
		'priority' => 59,
		'fields' => array(
			'shop_archive_pp' => array(
				'label'   => esc_html__( 'Archive shop items per row', 'splash' ),
				'type'    => 'radio',
				'choices' => array(
					'2'  => 2,
					'3' => 3,
					'4' => 4,
				),
				'default' => '3'
			),
			'shop_sidebar'          => array(
				'label'   => esc_html__( 'Choose shop sidebar', 'splash' ),
				'type'    => 'stm-select',
				'choices' => $sidebars,
				'default' => 'no_sidebar'
			),
			'shop_sidebar_position'         => array(
				'label'       => esc_html__( 'Shop Sidebar Position', 'splash' ),
				'type'    => 'radio',
				'choices' => array(
					'left'  => esc_html__( 'Left', 'splash' ),
					'right' => esc_html__( 'Right', 'splash' )
				),
				'default' => 'left'
			),
		)
	) );

	STM_Customizer::setSection( 'socials', array(
		'title'    => esc_html__( 'Socials', 'splash' ),
		'priority' => 60,
		'fields'   => array(
			'socials_link' => array(
				'label'   => esc_html__( 'Socials Links', 'splash' ),
				'type'    => 'stm-socials',
				'choices' => $socials
			)
		)
	) );

	STM_Customizer::setSection( 'css', array(
		'title'  => esc_html__( 'CSS', 'splash' ),
		'fields' => array(
			'custom_css' => array(
				'label'       => '',
				'type'        => 'stm-code',
				'placeholder' => ".classname {\n\tbackground: #000;\n}"
			)
		)
	) );
}
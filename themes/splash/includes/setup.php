<?php

if ( ! isset( $content_width ) ) $content_width = 1170;

add_action( 'after_setup_theme', 'splash_local_theme_setup' );
function splash_local_theme_setup(){

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'sportspress' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption'
	) );

	add_image_size( 'stm-1170-650', 1170, 650, true );
	add_image_size( 'stm-570-350', 570, 350, true );
	add_image_size( 'stm-570-250', 570, 250, true );
	add_image_size( 'stm-270-370', 270, 370, true );
	add_image_size( 'stm-540-500', 540, 500, array( 'center', 'top' ) );
	add_image_size( 'stm-270-530', 270, 530, true );
	add_image_size( 'stm-200-200', 200, 200, true );
	add_image_size( 'stm-85-105', 85, 105, true );


	load_theme_textdomain( 'splash', get_template_directory() . '/languages' );

	register_nav_menus( array(
		'primary'   => esc_html__( 'Header menu', 'splash' ),
		'bottom_menu'   => esc_html__( 'Bottom Widget menu', 'splash' ),
		'sidebar_menu'   => esc_html__( 'Sidebar menu', 'splash' ),
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'splash' ),
		'id'            => 'default',
		'description'   => esc_html__( 'Main sidebar that appears on the right or left.', 'splash' ),
		'before_widget' => '<aside id="%1$s" class="widget widget-default %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="widget-title"><h4>',
		'after_title'   => '</h4></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'splash' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Footer Widgets Area', 'splash' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<div class="widget-title"><h6>',
		'after_title'   => '</h6></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'SportsPress', 'splash' ),
		'id'            => 'sportspress',
		'description'   => esc_html__( 'SportsPress Widgets Area', 'splash' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<div class="widget-title"><h6>',
		'after_title'   => '</h6></div>',
	) );

	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Shop', 'splash' ),
			'id'            => 'shop',
			'description'   => esc_html__( 'Woocommerce pages sidebar', 'splash' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="widget_title"><h3>',
			'after_title'   => '</h3></div>',
		) );
	}

}
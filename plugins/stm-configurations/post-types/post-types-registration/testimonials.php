<?php

add_action( 'init', 'stm_testimonial_init' );
/**
 * Register a Testimonial post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function stm_testimonial_init() {
	$labels = array(
		'name'               => _x( 'Testimonials', 'post type general name', 'stm-configurations' ),
		'singular_name'      => _x( 'Testimonial', 'post type singular name', 'stm-configurations' ),
		'menu_name'          => _x( 'Testimonials', 'admin menu', 'stm-configurations' ),
		'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'stm-configurations' ),
		'add_new'            => _x( 'Add New', 'Testimonial', 'stm-configurations' ),
		'add_new_item'       => __( 'Add New Testimonial', 'stm-configurations' ),
		'new_item'           => __( 'New Testimonial', 'stm-configurations' ),
		'edit_item'          => __( 'Edit Testimonial', 'stm-configurations' ),
		'view_item'          => __( 'View Testimonial', 'stm-configurations' ),
		'all_items'          => __( 'All Testimonials', 'stm-configurations' ),
		'search_items'       => __( 'Search Testimonials', 'stm-configurations' ),
		'parent_item_colon'  => __( 'Parent Testimonials:', 'stm-configurations' ),
		'not_found'          => __( 'No Testimonials found.', 'stm-configurations' ),
		'not_found_in_trash' => __( 'No Testimonials found in Trash.', 'stm-configurations' )
	);

	$args = array(
		'labels'             => $labels,
		'menu_icon'          => 'dashicons-format-chat',
		'description'        => __( 'Testimonial Post type.', 'stm-configurations' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'rewrite'            => array( 'slug' => 'testimonials' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' )
	);

	register_post_type( 'testimonial', $args );
}
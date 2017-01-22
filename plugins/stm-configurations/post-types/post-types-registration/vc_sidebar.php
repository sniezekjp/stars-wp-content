<?php

add_action( 'init', 'stm_sidebar_init' );
/**
 * Register a Sidebar post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function stm_Sidebar_init() {
	$labels = array(
		'name'               => _x( 'Sidebars', 'post type general name', 'stm-configurations' ),
		'singular_name'      => _x( 'Sidebar', 'post type singular name', 'stm-configurations' ),
		'menu_name'          => _x( 'Sidebars', 'admin menu', 'stm-configurations' ),
		'name_admin_bar'     => _x( 'Sidebar', 'add new on admin bar', 'stm-configurations' ),
		'add_new'            => _x( 'Add New', 'Sidebar', 'stm-configurations' ),
		'add_new_item'       => __( 'Add New Sidebar', 'stm-configurations' ),
		'new_item'           => __( 'New Sidebar', 'stm-configurations' ),
		'edit_item'          => __( 'Edit Sidebar', 'stm-configurations' ),
		'view_item'          => __( 'View Sidebar', 'stm-configurations' ),
		'all_items'          => __( 'All Sidebars', 'stm-configurations' ),
		'search_items'       => __( 'Search Sidebars', 'stm-configurations' ),
		'parent_item_colon'  => __( 'Parent Sidebars:', 'stm-configurations' ),
		'not_found'          => __( 'No Sidebars found.', 'stm-configurations' ),
		'not_found_in_trash' => __( 'No Sidebars found in Trash.', 'stm-configurations' )
	);

	$args = array(
		'labels'             => $labels,
		'menu_icon'          => 'dashicons-schedule',
		'description'        => __( 'Sidebar Post type.', 'stm-configurations' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'rewrite'            => array( 'slug' => 'sidebars' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' )
	);

	register_post_type( 'vc_sidebar', $args );
}
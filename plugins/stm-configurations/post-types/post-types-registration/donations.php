<?php

add_action( 'init', 'stm_donation_init' );
/**
 * Register a Donation post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function stm_Donation_init() {
	$labels = array(
		'name'               => _x( 'Donations', 'post type general name', 'stm-configurations' ),
		'singular_name'      => _x( 'Donation', 'post type singular name', 'stm-configurations' ),
		'menu_name'          => _x( 'Donations', 'admin menu', 'stm-configurations' ),
		'name_admin_bar'     => _x( 'Donation', 'add new on admin bar', 'stm-configurations' ),
		'add_new'            => _x( 'Add New', 'Donation', 'stm-configurations' ),
		'add_new_item'       => __( 'Add New Donation', 'stm-configurations' ),
		'new_item'           => __( 'New Donation', 'stm-configurations' ),
		'edit_item'          => __( 'Edit Donation', 'stm-configurations' ),
		'view_item'          => __( 'View Donation', 'stm-configurations' ),
		'all_items'          => __( 'All Donations', 'stm-configurations' ),
		'search_items'       => __( 'Search Donations', 'stm-configurations' ),
		'parent_item_colon'  => __( 'Parent Donations:', 'stm-configurations' ),
		'not_found'          => __( 'No Donations found.', 'stm-configurations' ),
		'not_found_in_trash' => __( 'No Donations found in Trash.', 'stm-configurations' )
	);

	$args = array(
		'labels'             => $labels,
		'menu_icon'          => 'dashicons-smiley',
		'description'        => __( 'Donation Post type.', 'stm-configurations' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'donations' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' )
	);

	register_post_type( 'donation', $args );
}
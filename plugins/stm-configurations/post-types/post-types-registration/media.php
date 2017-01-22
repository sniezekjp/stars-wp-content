<?php

add_action( 'init', 'stm_media_gallery_init' );
/**
 * Register a Media Gallery post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function stm_media_gallery_init() {
	$labels = array(
		'name'               => _x( 'Media Galleries', 'post type general name', 'stm-configurations' ),
		'singular_name'      => _x( 'Media Gallery', 'post type singular name', 'stm-configurations' ),
		'menu_name'          => _x( 'Media Galleries', 'admin menu', 'stm-configurations' ),
		'name_admin_bar'     => _x( 'Media Gallery', 'add new on admin bar', 'stm-configurations' ),
		'add_new'            => _x( 'Add New', 'Media Gallery', 'stm-configurations' ),
		'add_new_item'       => __( 'Add New Media Gallery', 'stm-configurations' ),
		'new_item'           => __( 'New Media Gallery', 'stm-configurations' ),
		'edit_item'          => __( 'Edit Media Gallery', 'stm-configurations' ),
		'view_item'          => __( 'View Media Gallery', 'stm-configurations' ),
		'all_items'          => __( 'All Media Galleries', 'stm-configurations' ),
		'search_items'       => __( 'Search Media Galleries', 'stm-configurations' ),
		'parent_item_colon'  => __( 'Parent Media Galleries:', 'stm-configurations' ),
		'not_found'          => __( 'No Media Galleries found.', 'stm-configurations' ),
		'not_found_in_trash' => __( 'No Media Galleries found in Trash.', 'stm-configurations' )
	);

	$args = array(
		'labels'             => $labels,
		'menu_icon'          => 'dashicons-camera',
		'description'        => __( 'Media Gallery post type.', 'stm-configurations' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'rewrite'            => array( 'slug' => 'medias' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'thumbnail' )
	);

	register_post_type( 'media_gallery', $args );
}
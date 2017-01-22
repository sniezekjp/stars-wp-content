<?php
/**
 * @package WordPress
 * @subpackage ThemeWoot
 * @author ThemeWoot Team 
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if( ! class_exists( 'Twoot_Post_Types') ) {
/**
 * Post Types Class
 *
 * @class Twoot_Post_Types
 * @version	1.0
 * @since 1.0
 * @package ThemeWoot
 * @author ThemeWoot Team 
 */
class Twoot_Post_Types {

	public $types;
	/**
	* Init custom post types
	* @since     1.0
	* @updated   1.0
	*
	*/
	public function init($types) {
		foreach ($types as $type) {	
			add_action('init', array(&$this, $type));
			if($type!='portfolio') { 
				add_action('template_redirect', array(&$this, $type.'_context_fixer')); 
			}
		}
	}


	/**
	 * Portfolio
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function portfolio() {
		$labels = array(
			'name'                => _x( 'Portfolios', 'Post Type General Name', 'Twoot_Toolkit' ),
			'singular_name'       => _x( 'Portfolio', 'Post Type Singular Name', 'Twoot_Toolkit' ),
			'menu_name'           => __( 'Portfolios', 'Twoot_Toolkit' ),
			'parent_item_colon'   => __( 'Parent Portfolio:', 'Twoot_Toolkit' ),
			'all_items'           => __( 'All Portfolios', 'Twoot_Toolkit' ),
			'view_item'           => __( 'View Portfolio', 'Twoot_Toolkit' ),
			'add_new_item'        => __( 'Add New Portfolio', 'Twoot_Toolkit' ),
			'add_new'             => __( 'New Portfolio', 'Twoot_Toolkit' ),
			'edit_item'           => __( 'Edit Portfolio', 'Twoot_Toolkit' ),
			'update_item'         => __( 'Update Portfolio', 'Twoot_Toolkit' ),
			'search_items'        => __( 'Search portfolios', 'Twoot_Toolkit' ),
			'not_found'           => __( 'No portfolios found', 'Twoot_Toolkit' ),
			'not_found_in_trash'  => __( 'No portfolios found in Trash', 'Twoot_Toolkit' )
		);

		$args = array(
			'label'               => __( 'portfolio', 'Twoot_Toolkit' ),
			'description'         => __( 'Portfolio information pages', 'Twoot_Toolkit' ),
			'labels'              => $labels,
			'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'page-attributes'),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite' => array('slug'=>get_option( TWOOT_PREFIX . 'portfolio_item_base' ),'with_front'=>true),
			'capability_type' => 'post'
		);


		register_post_type( 'portfolio' , $args );

		register_taxonomy('portfolio_cat','portfolio',array(
			'hierarchical' => true, 
			'label' => __('Portfolio Categories', 'Twoot_Toolkit'),
			'labels' => array(
				'name' 				=> __( 'Portfolio Categories', 'Twoot_Toolkit'),
				'singular_name' 	=> __( 'Portfolio Category', 'Twoot_Toolkit'),
				'menu_name'			=> __( 'Categories', 'Twoot_Toolkit' ),
				'search_items' 		=> __( 'Search Categories', 'Twoot_Toolkit'),
				'all_items' 		=> __( 'All Categories', 'Twoot_Toolkit'),
				'parent_item' 		=> __( 'Parent Category', 'Twoot_Toolkit'),
				'parent_item_colon' => __( 'Parent Category:', 'Twoot_Toolkit'),
				'edit_item' 		=> __( 'Edit Category', 'Twoot_Toolkit'),
				'update_item' 		=> __( 'Update Category', 'Twoot_Toolkit'),
				'add_new_item' 		=> __( 'Add New Category', 'Twoot_Toolkit'),
				'new_item_name' 	=> __( 'New Category Name', 'Twoot_Toolkit')
			),
			'rewrite' => array('slug' => get_option( TWOOT_PREFIX . 'portfolio_cat_base' )),
			'query_var' => true
		));

		register_taxonomy('portfolio_tag','portfolio',array(
			'hierarchical' => false,
			'label' => __('Portfolio Tags', 'Twoot_Toolkit'), 
			'labels' => array(
				'name' => __( 'Portfolio Tags', 'Twoot_Toolkit'),
				'singular_name' => __( 'Portfolio Tag', 'Twoot_Toolkit'),
				'menu_name'	=> __( 'Tags', 'Twoot_Toolkit' ),
				'search_items' => __( 'Search Portfolio Tags', 'Twoot_Toolkit'),
				'all_items' => __( 'All Portfolio Tags', 'Twoot_Toolkit'),
				'parent_item' => __( 'Parent Portfolio Tag', 'Twoot_Toolkit'),
				'parent_item_colon' => __( 'Parent Portfolio Tag:', 'Twoot_Toolkit'),
				'edit_item' => __( 'Edit Portfolio Tag', 'Twoot_Toolkit'),
				'update_item' 	=> __( 'Update Portfolio Tag', 'Twoot_Toolkit'),
				'add_new_item' => __( 'Add New Portfolio Tag', 'Twoot_Toolkit'),
				'new_item_name' => __( 'New Portfolio Tag Name', 'Twoot_Toolkit')
			),
			'show_in_nav_menus' => true,
			'rewrite' => array('slug' => get_option( TWOOT_PREFIX . 'portfolio_tag_base' ))
		));
	 }



	 /**
	 * Faq
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function faq() {
		$labels = array(
			'name'                => _x( 'FAQs', 'Post Type General Name', 'Twoot_Toolkit' ),
			'singular_name'       => _x( 'FAQ', 'Post Type Singular Name', 'Twoot_Toolkit' ),
			'menu_name'           => __( 'FAQs', 'Twoot_Toolkit' ),
			'parent_item_colon'   => __( 'Parent FAQ:', 'Twoot_Toolkit' ),
			'all_items'           => __( 'All FAQs', 'Twoot_Toolkit' ),
			'view_item'           => __( 'View FAQ', 'Twoot_Toolkit' ),
			'add_new_item'        => __( 'Add New FAQ', 'Twoot_Toolkit' ),
			'add_new'             => __( 'New FAQ', 'Twoot_Toolkit' ),
			'edit_item'           => __( 'Edit FAQ', 'Twoot_Toolkit' ),
			'update_item'         => __( 'Update FAQ', 'Twoot_Toolkit' ),
			'search_items'        => __( 'Search FAQs', 'Twoot_Toolkit' ),
			'not_found'           => __( 'No FAQs found', 'Twoot_Toolkit' ),
			'not_found_in_trash'  => __( 'No FAQs found in Trash', 'Twoot_Toolkit' )
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'show_in_nav_menus' => false,
			'show_in_admin_bar'   => true,
			'query_var' => false,
			'can_export' => true,
			'rewrite' => false,
			'hierarchical' => false,
			'has_archive' => false,
			'supports' => array('title', 'editor', 'page-attributes')
		);
		
		register_post_type( 'faq' , $args );

		register_taxonomy('faq_cat','faq',array(
			'hierarchical' => true, 
			'label' => esc_attr__('Categories', 'Twoot_Toolkit'),
			'singular_label' => esc_attr__('Category', 'Twoot_Toolkit'), 
			'rewrite' => false,
			'show_in_nav_menus' => false,
			'query_var' => false
		));
	 }


	  /**
	 * Faq Context Fixer
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function faq_context_fixer()  {
		 if ( get_query_var( 'post_type' ) == 'faq' ) {
			global $wp_query;
			$wp_query->is_home = false;
			$wp_query->is_404 = true;
			$wp_query->is_single = false;
			$wp_query->is_singular = false;
		}
	 }


	  /**
	 * Bx Slider
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function bx_slider() {
		$labels = array(
			'name'                => _x( 'Bx Sliders', 'Post Type General Name', 'Twoot_Toolkit' ),
			'singular_name'       => _x( 'Bx Slider', 'Post Type Singular Name', 'Twoot_Toolkit' ),
			'menu_name'           => __( 'Bx Sliders', 'Twoot_Toolkit' ),
			'parent_item_colon'   => __( 'Parent Bx Slider:', 'Twoot_Toolkit' ),
			'all_items'           => __( 'All Bx Sliders', 'Twoot_Toolkit' ),
			'view_item'           => __( 'View Bx Slider', 'Twoot_Toolkit' ),
			'add_new_item'        => __( 'Add New Bx Slider', 'Twoot_Toolkit' ),
			'add_new'             => __( 'New Bx Slider', 'Twoot_Toolkit' ),
			'edit_item'           => __( 'Edit Bx Slider', 'Twoot_Toolkit' ),
			'update_item'         => __( 'Update Bx Slider', 'Twoot_Toolkit' ),
			'search_items'        => __( 'Search Bx Sliders', 'Twoot_Toolkit' ),
			'not_found'           => __( 'No bx sliders found', 'Twoot_Toolkit' ),
			'not_found_in_trash'  => __( 'No bx sliders found in Trash', 'Twoot_Toolkit' )
		);

		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_admin_bar'   => true,
			'query_var' => false,
			'can_export' => true,
			'rewrite' => false,
			'hierarchical' => false,
			'has_archive' => false,
			'show_in_nav_menus' => false,
			'supports' => array('title', 'thumbnail', 'page-attributes')
		); 
		
		register_post_type( 'bx_slider' , $args );

		register_taxonomy('bx_slider_cat','bx_slider',array(
			'hierarchical' => true, 
			'label' => esc_attr__('Categories', 'Twoot_Toolkit'),
			'singular_label' => esc_attr__('Category', 'Twoot_Toolkit'), 
			'rewrite' => false,
			'show_in_nav_menus' => false,
			'query_var' => false
		));
	 }


	  /**
	 * Bx Sldier Context Fixer
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function bx_slider_context_fixer() {
		if ( get_query_var( 'post_type' ) == 'bx_slider' ) {
			global $wp_query;
			$wp_query->is_home = false;
			$wp_query->is_404 = true;
			$wp_query->is_single = false;
			$wp_query->is_singular = false;
		}
	 }


	  /**
	 * Content Block
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function content_block() {
		$labels = array(
			'name'                => _x( 'Content Blocks', 'Post Type General Name', 'Twoot_Toolkit' ),
			'singular_name'       => _x( 'Content Block', 'Post Type Singular Name', 'Twoot_Toolkit' ),
			'menu_name'           => __( 'Content Blocks', 'Twoot_Toolkit' ),
			'parent_item_colon'   => __( 'Parent Content Block:', 'Twoot_Toolkit' ),
			'all_items'           => __( 'All Content Blocks', 'Twoot_Toolkit' ),
			'view_item'           => __( 'View Content Block', 'Twoot_Toolkit' ),
			'add_new_item'        => __( 'Add New Content Block', 'Twoot_Toolkit' ),
			'add_new'             => __( 'New Content Block', 'Twoot_Toolkit' ),
			'edit_item'           => __( 'Edit Content Block', 'Twoot_Toolkit' ),
			'update_item'         => __( 'Update Content Block', 'Twoot_Toolkit' ),
			'search_items'        => __( 'Search Content Blocks', 'Twoot_Toolkit' ),
			'not_found'           => __( 'No content block found', 'Twoot_Toolkit' ),
			'not_found_in_trash'  => __( 'No content block found in Trash', 'Twoot_Toolkit' )
		);

		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_admin_bar' => true,
			'query_var' => false,
			'can_export' => true,
			'rewrite' => false,
			'hierarchical' => false,
			'has_archive' => false,
			'show_in_nav_menus' => false,
			'supports' => array('title', 'editor')
		); 
		
		register_post_type( 'content_block' , $args );
	 }


	  /**
	 * Content Block Context Fixer
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function content_block_context_fixer() {
		 if ( get_query_var( 'post_type' ) == 'content_block' ) {
			global $wp_query;
			$wp_query->is_home = false;
			$wp_query->is_404 = true;
			$wp_query->is_single = false;
			$wp_query->is_singular = false;
		}
	 }


	  /**
	 * Testimonial
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function testimonial() {
		$labels = array(
			'name'                => _x( 'Testimonials', 'Post Type General Name', 'Twoot_Toolkit' ),
			'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'Twoot_Toolkit' ),
			'menu_name'           => __( 'Testimonials', 'Twoot_Toolkit' ),
			'parent_item_colon'   => __( 'Parent Testimonial:', 'Twoot_Toolkit' ),
			'all_items'           => __( 'All Testimonials', 'Twoot_Toolkit' ),
			'view_item'           => __( 'View Testimonial', 'Twoot_Toolkit' ),
			'add_new_item'        => __( 'Add New Testimonial', 'Twoot_Toolkit' ),
			'add_new'             => __( 'New Testimonial', 'Twoot_Toolkit' ),
			'edit_item'           => __( 'Edit Testimonial', 'Twoot_Toolkit' ),
			'update_item'         => __( 'Update Testimonial', 'Twoot_Toolkit' ),
			'search_items'        => __( 'Search Testimonials', 'Twoot_Toolkit' ),
			'not_found'           => __( 'No testimonial found', 'Twoot_Toolkit' ),
			'not_found_in_trash'  => __( 'No testimonial found in Trash', 'Twoot_Toolkit' )
		);

		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_admin_bar' => true,
			'query_var' => false,
			'can_export' => true,
			'rewrite' => false,
			'hierarchical' => false,
			'has_archive' => false,
			'show_in_nav_menus' => false,
			'supports' => array('title', 'editor', 'thumbnail', 'page-attributes')
		); 
		
		register_post_type( 'testimonial' , $args );
	 }


	  /**
	 * Testimonial Context Fixer
	 * @since     1.0
	 * @updated   1.0
	 *
	 */
	 public function testimonial_context_fixer() {
		 if ( get_query_var( 'post_type' ) == 'testimonial' ) {
			global $wp_query;
			$wp_query->is_home = false;
			$wp_query->is_404 = true;
			$wp_query->is_single = false;
			$wp_query->is_singular = false;
		}
	 }
}
}
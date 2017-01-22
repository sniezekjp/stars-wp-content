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

if ( !function_exists( 'shortcode_blog_grid' ) ) {

	function shortcode_blog_grid($atts, $content = null) {
		extract(shortcode_atts(array(
			'tax'	=> 'cat',
			'columns' => '4',
			'counts' => '12',
			'cats'=> '',
			'posts' => '',
			'order' => 'DESC',
			'orderby' => 'date',
			'filter' => 'yes',
			'paging' => 'yes'
		), $atts));

		if( ! in_array($tax, array('cat', 'tag'), true) ) {
			return $html = '<div class="the-not-posts">'.esc_attr__('Hi, please check the taxonomy option, the current tax is not match!', 'Twoot_Toolkit').'</div>';
		}

		switch($tax) {
			case 'cat': $taxonomy='category'; break;
			case 'tag': $taxonomy='post_tag'; break;
		}

		$q = new Twoot_Template_Grid(array(
			'columns' => $columns,
			'counts' => $counts,
			'cats'=> $cats,
			'posts' => $posts,
			'order' => $order,
			'orderby' => $orderby,
			'filter' => $filter,
			'paging' => $paging,
			'post_type'	=> 'post',
			'taxonomy'  => $taxonomy
		));

		return $q->grid();
	}

	add_shortcode('blog_grid', 'shortcode_blog_grid');
}

?>
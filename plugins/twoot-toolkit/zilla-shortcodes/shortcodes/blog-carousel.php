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

if ( !function_exists( 'shortcode_blog_carousel' ) ) {
	function shortcode_blog_carousel($atts, $content = null) {
		extract(shortcode_atts(array(
			'title' => 'Recent News',
			'tax'	=> 'cat',
			'counts' => '16',
			'cats'=> '',
			'posts' => '',
			'order' => 'DESC',
			'orderby' => 'date',
			'auto' => 'false',
			'speed' => '800',
			'pause' => '5000',
			'move_slides' => '4'
		), $atts));

		$id=twoot_get_frontend_func('rand_num', 5);
		
		if( ! in_array($tax, array('cat', 'tag'), true) ) {
			return $html = '<div class="the-not-posts">'.esc_attr__('Hi, please check the taxonomy option, the current tax is not match!', 'Twoot_Toolkit').'</div>';
		}

		switch($tax) {
			case 'cat': $taxonomy='category'; break;
			case 'tag': $taxonomy='post_tag'; break;
		}

		$q = new Twoot_Template_Carousel(array(
			'counts' => $counts,
			'cats'=> $cats,
			'posts' => $posts,
			'order' => $order,
			'orderby' => $orderby,
			'post_type'	=> 'post',
			'taxonomy'  => $taxonomy
		));

		$html = '<div class="the-carousel-list the-blog-carousel">';
		$html .= '<h5 class="carousel-title section-title">'.$title.'</h5>';
		$html .= '<ul id="post-carousel-'.$id.'" class="clearfix">';
		$html .= $q->carousel();
		$html .= '</ul>';
		$html .= '</div>';

		$html .= twoot_generator('carousel_script', $id, $auto, $speed, $pause, $move_slides, $tag='b');

		return $html;
	}

	add_shortcode('blog_carousel', 'shortcode_blog_carousel');
}

?>
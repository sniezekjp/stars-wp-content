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

if ( !function_exists( 'shortcode_testimonials' ) ) {

	function shortcode_testimonials($atts, $content = null) {
		extract(shortcode_atts(array(
			'counts' => '5',
			'posts' => '',
			'order' => 'DESC',
			'orderby' => 'date'
		), $atts));

		// Get Query
		$query = new Twoot_Query(array(
			'counts' => $counts,
			'cats'=> '',
			'posts' => $posts,
			'order' => $order,
			'orderby' => $orderby,
			'post_type'	=> 'testimonial',
			'taxonomy'  => ''
		));

		$do_query = new WP_Query($query->do_template_query());

		$html = '<div class="shortcode-testimonials">';
		$html .= '<ul>';
		while( $do_query->have_posts() ) {
			$do_query->the_post();
			$html .= '<li class="testimonial-item clearfix">';
			$html .= twoot_generator( 'load_template', 'loop-testimonial' );
			$html .= '</li>';
		}
		wp_reset_postdata();
		$html .= '</ul>';
		$html .= '</div>';
		
		return $html;
	}

	add_shortcode('testimonials', 'shortcode_testimonials');
}
?>
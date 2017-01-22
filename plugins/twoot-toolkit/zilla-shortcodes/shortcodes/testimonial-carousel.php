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

if ( !function_exists( 'shortcode_testimonial_carousel' ) ) {

	function shortcode_testimonial_carousel($atts, $content = null) {

		extract(shortcode_atts(array(
			'counts' => '12',
			'posts' => '',
			'order' => 'DESC',
			'orderby' => 'date',
			'auto' => 'true',
			'speed' => '800',
			'pause' => '5000',
			'mode' => 'fade'
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

		$html = '<div class="shortcode-testimonials shortcode-testimonial-carousel">';
		$html .= '<ul class="testimonial-carousel" data-auto="'.$auto.'" data-speed="'.$speed.'" data-pause="'.$pause.'" data-mode="'.$mode.'">';
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

	add_shortcode('testimonial_carousel', 'shortcode_testimonial_carousel');
}
?>
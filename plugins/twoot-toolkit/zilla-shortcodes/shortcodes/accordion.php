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

if ( !function_exists( 'shortcode_accordions' ) ) {

	function shortcode_accordions( $atts, $content = null) {

		global $accordions_args;
		$accordions_args = array();

		do_shortcode($content);

		$html = '<div class="shortcode-accordion">';

		foreach( $accordions_args as $accordion ) {
			$html .= '<div class="acc-item">';
			$html .= '<a href="#" class="tog"><i class="icon"></i>'. $accordion['title'] .'</a>';
			$html .= '<div class="acc-content clearfix">'. do_shortcode($accordion['content']) .'</div>';
			$html .= '</div>';
		}

		$html .= '</div>';	
		
		return $html;
	}


	function shortcode_accordion($atts, $content = null) {

		extract(shortcode_atts(array(
			'title' => 'Title goes here'
		), $atts));

		global $accordions_args;

		$accordions_args[] = array(
			'title' => $title,
			'content' => $content
		);
	}

	add_shortcode('accordions', 'shortcode_accordions');
	add_shortcode('accordion', 'shortcode_accordion');
}
?>
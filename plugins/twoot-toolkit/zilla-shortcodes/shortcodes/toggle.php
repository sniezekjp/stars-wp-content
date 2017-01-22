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

if ( !function_exists( 'shortcode_toggles' ) ) {

	function shortcode_toggles( $atts, $content = null) {

		global $toggles_args;
		$toggles_args = array();

		do_shortcode($content);

		$html = '<div class="shortcode-toggle">';

		foreach( $toggles_args as $toggle ) {
			$html .= '<div class="tog-item">';
			$html .= '<a href="#" class="tog"><i class="icon"></i>'. $toggle['title'] .'</a>';
			$html .= '<div class="tog-content clearfix">'. do_shortcode($toggle['content']) .'</div>';
			$html .= '</div>';
		}

		$html .= '</div>';	
		
		return $html;
	}


	function shortcode_toggle($atts, $content = null) {

		extract(shortcode_atts(array(
			'title' => 'Title goes here'
		), $atts));

		global $toggles_args;

		$toggles_args[] = array(
			'title' => $title,
			'content' => $content
		);
	}

	add_shortcode('toggles', 'shortcode_toggles');
	add_shortcode('toggle', 'shortcode_toggle');
}
?>
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

if ( !function_exists( 'shortcode_tabs' ) ) {

	function shortcode_tabs( $atts, $content = null) {

		global $tabs_args;
		$tabs_args = array();

		do_shortcode($content);

		$html = '<div class="shortcode-tab shortcode-tab-wrap">';
		$html .= '<ul class="tabs etabs clearfix">';

		foreach( $tabs_args as $tab ) {
			$html .= '<li class="tab"><a href="#' . sanitize_title($tab['title']) . '">' . $tab['title'] . '</a></li>';
		}

		$html .= '</ul>';
		$html .= '<div class="tabs-content">';

		foreach( $tabs_args as $tab ) {
			$html .= '<div id="' . sanitize_title($tab['title']) . '">' . do_shortcode($tab['content']) . '</div>';
		}

		$html .= '</div>';
		$html .= '</div>';
		
		return $html;
	}


	function shortcode_tab($atts, $content = null) {

		extract(shortcode_atts(array(
			'title' => 'Title goes here'
		), $atts));

		global $tabs_args;

		$tabs_args[] = array(
			'title' => $title,
			'content' => $content
		);
	}

	add_shortcode('tabs', 'shortcode_tabs');
	add_shortcode('tab', 'shortcode_tab');
}
?>